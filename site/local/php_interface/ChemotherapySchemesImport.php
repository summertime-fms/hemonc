<?php

declare(strict_types=1);
namespace Hemonc;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Web\HttpClient;

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/.settings.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/.settings.php';
}

/**
 * Импорт схем химиотерапии из API 1С (JSON) в HL HlChemotherapySchemes.
 */
final class ChemotherapySchemesImport
{
    private const HL_BLOCK_NAME = 'HlChemotherapySchemes';

    private const THROTTLE_SECONDS = 90;

    public static function agentRun(): string
    {
        try {
            self::run(false);
        } catch (\Throwable $e) {
            self::logError($e);
        }

        return '';
    }

    public static function run(bool $force = false): array
    {
        if (!defined('ONEC_API_URL') || !defined('ONEC_API_LOGIN') || !defined('ONEC_API_PASSWORD')) {
            return ['ok' => false, 'status' => 'missing_config'];
        }

        if (trim((string) ONEC_API_URL) === '') {
            return ['ok' => false, 'status' => 'empty_url'];
        }

        if (!Loader::includeModule('highloadblock')) {
            return ['ok' => false, 'status' => 'no_highloadblock'];
        }

        if (!$force) {
            $last = \COption::GetOptionString('main', 'chemo_schemes_import_last_ok', '');
            if ($last !== '') {
                $ts = strtotime($last);
                if ($ts && (time() - $ts) < self::THROTTLE_SECONDS) {
                    return ['ok' => true, 'status' => 'throttled', 'skipped' => true];
                }
            }
        }

        $json = self::fetchJson();
        if ($json === null) {
            return ['ok' => false, 'status' => 'http_error'];
        }

        $data = json_decode($json, true);
        if (!is_array($data)) {
            self::logMessage('chemo_import: invalid JSON');

            return ['ok' => false, 'status' => 'invalid_json'];
        }

        $schemes = $data['chemotherapy_schemes'] ?? null;
        if (!is_array($schemes)) {
            return ['ok' => false, 'status' => 'no_schemes'];
        }

        $exportDateRaw = isset($data['export_date']) ? (string) $data['export_date'] : '';
        $exportDateHl = self::exportDateForHl($exportDateRaw);

        try {
            $dataClass = self::getDataClass();
        } catch (\Throwable $e) {
            self::logError($e);

            return ['ok' => false, 'status' => 'hl_not_found'];
        }

        $existing = self::loadExistingRows($dataClass);
        $incomingKeys = [];

        foreach ($schemes as $scheme) {
            if (!is_array($scheme)) {
                continue;
            }
            $incomingKeys[self::computeSchemeKeyFromApi($scheme)] = true;
        }

        $imported = 0;
        $errors = [];

        foreach ($schemes as $scheme) {
            if (!is_array($scheme)) {
                continue;
            }
            $key = self::computeSchemeKeyFromApi($scheme);
            $existingRow = $existing[$key] ?? null;

            $drugsJson = self::encodeJson(self::normalizeKeyDrugs($scheme['key_drugs'] ?? []));
            $diagJson = self::encodeJson(self::normalizeDiagnoses($scheme['diagnoses'] ?? []));

            // UF_XML_ID обязателен для свойства ИБ типа «Справочник» (directory): в b_iblock_element_property
            // хранится именно XML_ID строки HL, а не ID. Без него значение в админке часто не сохраняется.
            $fields = [
                'UF_XML_ID' => $key,
                'UF_NAME' => (string) ($scheme['scheme_name'] ?? ''),
                'UF_SCHEME_NAME_SHORT' => (string) ($scheme['scheme_name_short'] ?? ''),
                'UF_PRICE_MIN' => (int) ($scheme['price_min'] ?? 0),
                'UF_PRICE_MAX' => (int) ($scheme['price_max'] ?? 0),
                'UF_CASES_COUNT' => (int) ($scheme['cases_count'] ?? 0),
                'UF_EXPORT_DATE' => $exportDateHl,
                'UF_DRUGS' => $drugsJson,
                'UF_DIAGNOSES' => $diagJson,
                'UF_LAST_UPDATE' => new DateTime(),
            ];

            $lightFromApi = trim((string) ($scheme['scheme_name_light'] ?? ''));
            if ($existingRow !== null) {
                $lightSaved = trim((string) ($existingRow['UF_SCHEME_NAME_LIGHT'] ?? ''));
                if ($lightSaved !== '') {
                    $fields['UF_SCHEME_NAME_LIGHT'] = $existingRow['UF_SCHEME_NAME_LIGHT'];
                } else {
                    $fields['UF_SCHEME_NAME_LIGHT'] = $lightFromApi;
                }
            } else {
                $fields['UF_SCHEME_NAME_LIGHT'] = $lightFromApi;
            }

            $result = $existingRow !== null
                ? $dataClass::update((int) $existingRow['ID'], $fields)
                : $dataClass::add($fields);

            if ($result->isSuccess()) {
                $imported++;
            } else {
                $errors[] = implode('; ', $result->getErrorMessages());
            }
        }

        $deleted = 0;
        foreach ($existing as $key => $row) {
            if (!isset($incomingKeys[$key])) {
                $del = $dataClass::delete((int) $row['ID']);
                if ($del->isSuccess()) {
                    $deleted++;
                }
            }
        }

        $mkbResult = self::syncMkbDiagnosesHl($schemes);
        $mkbImported = $mkbResult['imported'];
        $mkbErrors = $mkbResult['errors'];
        if (!empty($mkbErrors)) {
            self::logMessage('chemo_import_mkb: ' . implode(' | ', array_slice($mkbErrors, 0, 5)));
        }

        if (empty($errors)) {
            \COption::SetOptionString('main', 'chemo_schemes_import_last_ok', date('c'));
        }

        if (!empty($errors)) {
            self::logMessage('chemo_import: ' . implode(' | ', array_slice($errors, 0, 5)));
        }

        return [
            'ok' => empty($errors),
            'status' => empty($errors) ? 'ok' : 'partial_errors',
            'imported' => $imported,
            'deleted' => $deleted,
            'errors' => $errors,
            'mkb_imported' => $mkbImported,
            'mkb_errors' => $mkbErrors,
        ];
    }

    private static function syncMkbDiagnosesHl(array $schemes): array
    {
        if (!defined('HL_DIAGNOSES_MKB_ID') || (int) HL_DIAGNOSES_MKB_ID <= 0) {
            return ['imported' => 0, 'errors' => []];
        }

        $unique = [];
        foreach ($schemes as $scheme) {
            if (!is_array($scheme)) {
                continue;
            }
            foreach ($scheme['diagnoses'] ?? [] as $d) {
                if (!is_array($d)) {
                    continue;
                }
                $code = trim((string) ($d['mkb'] ?? ''));
                if ($code === '') {
                    continue;
                }
                $norm = mb_strtoupper($code);
                $name = trim((string) ($d['name'] ?? ''));
                $short = trim((string) ($d['namelight'] ?? ''));
                if (!isset($unique[$norm])) {
                    $unique[$norm] = ['name' => $name, 'short' => $short];
                } else {
                    if ($unique[$norm]['name'] === '' && $name !== '') {
                        $unique[$norm]['name'] = $name;
                    }
                    if ($unique[$norm]['short'] === '' && $short !== '') {
                        $unique[$norm]['short'] = $short;
                    }
                }
            }
        }

        if ($unique === []) {
            return ['imported' => 0, 'errors' => []];
        }

        try {
            $dataClass = self::getMkbDataClass();
        } catch (\Throwable $e) {
            self::logError($e);

            return ['imported' => 0, 'errors' => [$e->getMessage()]];
        }

        $existing = [];
        $res = $dataClass::getList([
            'select' => ['ID', 'UF_XML_ID', 'UF_MKB_CODE', 'UF_NAME', 'UF_SHORTNAME'],
        ]);
        while ($row = $res->fetch()) {
            $c = mb_strtoupper(trim((string) ($row['UF_MKB_CODE'] ?? '')));
            if ($c !== '') {
                $existing[$c] = $row;
            }
        }

        $imported = 0;
        $errors = [];

        foreach ($unique as $norm => $payload) {
            $name = (string) ($payload['name'] ?? '');
            $short = (string) ($payload['short'] ?? '');
            $row = $existing[$norm] ?? null;
            if ($row !== null && trim($short) === '') {
                $savedShort = trim((string) ($row['UF_SHORTNAME'] ?? ''));
                if ($savedShort !== '') {
                    $short = $savedShort;
                }
            }
            $fields = [
                'UF_XML_ID' => $norm,
                'UF_MKB_CODE' => $norm,
                'UF_NAME' => $name,
                'UF_SHORTNAME' => $short,
            ];
            $result = $row !== null
                ? $dataClass::update((int) $row['ID'], $fields)
                : $dataClass::add($fields);

            if ($result->isSuccess()) {
                $imported++;
            } else {
                $errors[] = $norm . ': ' . implode('; ', $result->getErrorMessages());
            }
        }

        return ['imported' => $imported, 'errors' => $errors];
    }

    private static function getMkbDataClass(): string
    {
        $hlId = (int) HL_DIAGNOSES_MKB_ID;
        $hlblock = HighloadBlockTable::getById($hlId)->fetch();
        if (!$hlblock) {
            throw new \RuntimeException('Highload-блок диагнозов МКБ с ID=' . $hlId . ' не найден');
        }

        $entity = HighloadBlockTable::compileEntity($hlblock);

        return $entity->getDataClass();
    }

    private static function getDataClass(): string
    {
        if (defined('HL_CHEMO_SCHEMES_ID') && (int) HL_CHEMO_SCHEMES_ID > 0) {
            $hlblock = HighloadBlockTable::getById((int) HL_CHEMO_SCHEMES_ID)->fetch();
        } else {
            $hlblock = HighloadBlockTable::getList([
                'filter' => ['=NAME' => self::HL_BLOCK_NAME],
                'limit' => 1,
            ])->fetch();
        }

        if (!$hlblock) {
            throw new \RuntimeException('Highload-блок с именем ' . self::HL_BLOCK_NAME . ' не найден');
        }

        $entity = HighloadBlockTable::compileEntity($hlblock);

        return $entity->getDataClass();
    }


    private static function exportDateForHl(string $exportDate): Date
    {
        $s = trim($exportDate);
        if ($s !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $s)) {
            try {
                return new Date($s, 'Y-m-d');
            } catch (\Throwable $e) {
                // fallback ниже
            }
        }
        if ($s !== '' && preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/', $s, $m)) {
            try {
                return new Date($m[3] . '-' . $m[2] . '-' . $m[1], 'Y-m-d');
            } catch (\Throwable $e) {
                // fallback ниже
            }
        }

        return new Date();
    }

    private static function fetchJson(): ?string
    {
        $http = new HttpClient([
            'socketTimeout' => 120,
            'timeout' => 120,
            'waitResponse' => true,
        ]);
        $http->setAuthorization((string) ONEC_API_LOGIN, (string) ONEC_API_PASSWORD);
        $http->setHeader('Accept', 'application/json', true);

        $ok = $http->get((string) ONEC_API_URL);
        $body = $http->getResult();
        $status = $http->getStatus();

        if (!$ok || $status !== 200) {
            self::logMessage('chemo_import: HTTP ' . $status . ' ' . mb_substr((string) $body, 0, 500));

            return null;
        }

        return is_string($body) ? $body : null;
    }

    public static function computeSchemeKeyFromApi(array $scheme): string
    {
        $name = (string) ($scheme['scheme_name'] ?? '');
        $short = (string) ($scheme['scheme_name_short'] ?? '');
        $min = (int) ($scheme['price_min'] ?? 0);
        $max = (int) ($scheme['price_max'] ?? 0);
        $mnns = [];
        foreach ($scheme['key_drugs'] ?? [] as $d) {
            if (!is_array($d)) {
                continue;
            }
            $mnn = trim((string) ($d['mnn'] ?? ''));
            if ($mnn !== '') {
                $mnns[] = mb_strtolower($mnn);
            }
        }
        sort($mnns, SORT_STRING);

        return sha1($name . "\0" . $short . "\0" . $min . "\0" . $max . "\0" . implode('|', $mnns));
    }

    public static function computeSchemeKeyFromRow(array $row): string
    {
        $name = (string) ($row['UF_NAME'] ?? '');
        $short = (string) ($row['UF_SCHEME_NAME_SHORT'] ?? '');
        $min = (int) ($row['UF_PRICE_MIN'] ?? 0);
        $max = (int) ($row['UF_PRICE_MAX'] ?? 0);
        $mnns = [];
        $raw = $row['UF_DRUGS'] ?? '[]';
        $drugs = is_string($raw) ? json_decode($raw, true) : [];
        if (is_array($drugs)) {
            foreach ($drugs as $d) {
                if (!is_array($d)) {
                    continue;
                }
                $mnn = trim((string) ($d['mnn'] ?? ''));
                if ($mnn !== '') {
                    $mnns[] = mb_strtolower($mnn);
                }
            }
        }
        sort($mnns, SORT_STRING);

        return sha1($name . "\0" . $short . "\0" . $min . "\0" . $max . "\0" . implode('|', $mnns));
    }

    private static function loadExistingRows(string $dataClass): array
    {
        $out = [];
        $res = $dataClass::getList([
            'select' => [
                'ID',
                'UF_NAME',
                'UF_SCHEME_NAME_SHORT',
                'UF_SCHEME_NAME_LIGHT',
                'UF_PRICE_MIN',
                'UF_PRICE_MAX',
                'UF_DRUGS',
            ],
        ]);
        while ($row = $res->fetch()) {
            $key = self::computeSchemeKeyFromRow($row);
            $out[$key] = $row;
        }

        return $out;
    }


    private static function normalizeKeyDrugs(array $keyDrugs): array
    {
        $out = [];
        foreach ($keyDrugs as $d) {
            if (!is_array($d)) {
                continue;
            }
            $out[] = ['mnn' => (string) ($d['mnn'] ?? '')];
        }

        return $out;
    }

    private static function normalizeDiagnoses(array $diagnoses): array
    {
        $out = [];
        foreach ($diagnoses as $d) {
            if (!is_array($d)) {
                continue;
            }
            $out[] = [
                'mkb' => (string) ($d['mkb'] ?? ''),
                'name' => (string) ($d['name'] ?? ''),
                'namelight' => (string) ($d['namelight'] ?? ''),
            ];
        }

        return $out;
    }

    private static function encodeJson(array $data): string
    {
        $s = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($s === false) {
            return '[]';
        }

        return $s;
    }

    private static function logError(\Throwable $e): void
    {
        self::logMessage('chemo_import exception: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    }

    private static function logMessage(string $msg): void
    {
        if (class_exists(\Bitrix\Main\Diag\Debug::class)) {
            \Bitrix\Main\Diag\Debug::writeToFile($msg, '', '/local/logs/chemo_import.log');
        }
    }
}

/**
 * Импорт справочника диагнозов МКБ из 1С (JSON action=getdiagnoses) в HL HL_DIAGNOSES_MKB_ID.
 */
final class DiagnosesCatalogImport
{
    private const THROTTLE_SECONDS = 90;

    private const OPTION_LAST_OK = 'diagnoses_catalog_import_last_ok';

    public static function agentRun(): string
    {
        try {
            self::run(false);
        } catch (\Throwable $e) {
            self::logError($e);
        }

        return '';
    }

    public static function run(bool $force = false): array
    {
        if (!defined('ONEC_API_LOGIN') || !defined('ONEC_API_PASSWORD')) {
            return ['ok' => false, 'status' => 'missing_config'];
        }

        if (!Loader::includeModule('highloadblock')) {
            return ['ok' => false, 'status' => 'no_highloadblock'];
        }

        $url = self::diagnosesApiUrl();
        if ($url === null || $url === '') {
            return ['ok' => false, 'status' => 'empty_url'];
        }

        if (!$force) {
            $last = \COption::GetOptionString('main', self::OPTION_LAST_OK, '');
            if ($last !== '') {
                $ts = strtotime($last);
                if ($ts && (time() - $ts) < self::THROTTLE_SECONDS) {
                    return ['ok' => true, 'status' => 'throttled', 'skipped' => true];
                }
            }
        }

        $json = self::fetchJson($url);
        if ($json === null) {
            return ['ok' => false, 'status' => 'http_error'];
        }

        $data = json_decode($json, true);
        if (!is_array($data)) {
            self::logMessage('diagnoses_import: invalid JSON');

            return ['ok' => false, 'status' => 'invalid_json'];
        }

        $rows = $data['diagnoses'] ?? null;
        if (!is_array($rows)) {
            return ['ok' => false, 'status' => 'no_diagnoses'];
        }

        if (!defined('HL_DIAGNOSES_MKB_ID') || (int) HL_DIAGNOSES_MKB_ID <= 0) {
            return ['ok' => false, 'status' => 'no_hl_diagnoses_id'];
        }

        try {
            $dataClass = self::getMkbDataClass();
        } catch (\Throwable $e) {
            self::logError($e);

            return ['ok' => false, 'status' => 'hl_not_found'];
        }

        $normalized = [];
        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }
            $mkb = trim((string) ($row['mkb'] ?? ''));
            if ($mkb === '') {
                continue;
            }
            $norm = mb_strtoupper($mkb);
            $name = trim((string) ($row['name'] ?? ''));
            $short = trim((string) ($row['namelight'] ?? ''));
            $normalized[] = ['mkb' => $norm, 'name' => $name, 'short' => $short];
        }

        if ($normalized === []) {
            return ['ok' => true, 'status' => 'empty_feed', 'imported' => 0, 'errors' => []];
        }

        $byMkb = [];
        foreach ($normalized as $item) {
            $byMkb[$item['mkb']][] = $item;
        }

        foreach ($byMkb as $mkb => &$items) {
            usort($items, static function (array $a, array $b): int {
                $cmp = strcmp($a['name'], $b['name']);
                if ($cmp !== 0) {
                    return $cmp;
                }

                return strcmp($a['short'] ?? '', $b['short'] ?? '');
            });
        }
        unset($items);

        $toUpsert = [];
        foreach ($byMkb as $mkb => $items) {
            $n = count($items);
            foreach ($items as $idx => $item) {
                $xmlId = ($n === 1)
                    ? $mkb
                    : ($idx === 0 ? $mkb : sha1($mkb . "\0" . $item['name']));
                $toUpsert[$xmlId] = [
                    'UF_XML_ID' => $xmlId,
                    'UF_MKB_CODE' => $mkb,
                    'UF_NAME' => $item['name'],
                    'UF_SHORTNAME' => (string) ($item['short'] ?? ''),
                ];
            }
        }

        $existing = [];
        $res = $dataClass::getList([
            'select' => ['ID', 'UF_XML_ID', 'UF_MKB_CODE', 'UF_NAME', 'UF_SHORTNAME'],
        ]);
        while ($row = $res->fetch()) {
            $xid = trim((string) ($row['UF_XML_ID'] ?? ''));
            if ($xid !== '') {
                $existing[$xid] = $row;
            }
        }

        $imported = 0;
        $errors = [];

        foreach ($toUpsert as $xmlId => $fields) {
            $row = $existing[$xmlId] ?? null;
            $result = $row !== null
                ? $dataClass::update((int) $row['ID'], $fields)
                : $dataClass::add($fields);

            if ($result->isSuccess()) {
                $imported++;
            } else {
                $errors[] = $xmlId . ': ' . implode('; ', $result->getErrorMessages());
            }
        }

        if (empty($errors)) {
            \COption::SetOptionString('main', self::OPTION_LAST_OK, date('c'));
        }

        if (!empty($errors)) {
            self::logMessage('diagnoses_import: ' . implode(' | ', array_slice($errors, 0, 5)));
        }

        return [
            'ok' => empty($errors),
            'status' => empty($errors) ? 'ok' : 'partial_errors',
            'imported' => $imported,
            'errors' => $errors,
        ];
    }

    private static function diagnosesApiUrl(): ?string
    {
        if (defined('ONEC_API_DIAGNOSES_URL') && trim((string) ONEC_API_DIAGNOSES_URL) !== '') {
            return trim((string) ONEC_API_DIAGNOSES_URL);
        }
        if (!defined('ONEC_API_URL')) {
            return null;
        }
        $base = trim((string) ONEC_API_URL);
        if ($base === '') {
            return null;
        }
        if (preg_match('/([&?])action=[^&]*/', $base)) {
            return preg_replace('/([&?])action=[^&]*/', '$1action=getdiagnoses', $base, 1);
        }

        return $base . ((strpos($base, '?') !== false) ? '&' : '?') . 'action=getdiagnoses';
    }

    private static function fetchJson(string $url): ?string
    {
        $http = new HttpClient([
            'socketTimeout' => 120,
            'timeout' => 120,
            'waitResponse' => true,
        ]);
        $http->setAuthorization((string) ONEC_API_LOGIN, (string) ONEC_API_PASSWORD);
        $http->setHeader('Accept', 'application/json', true);

        $ok = $http->get($url);
        $body = $http->getResult();
        $status = $http->getStatus();

        if (!$ok || $status !== 200) {
            self::logMessage('diagnoses_import: HTTP ' . $status . ' ' . mb_substr((string) $body, 0, 500));

            return null;
        }

        return is_string($body) ? $body : null;
    }

    private static function getMkbDataClass(): string
    {
        $hlId = (int) HL_DIAGNOSES_MKB_ID;
        $hlblock = HighloadBlockTable::getById($hlId)->fetch();
        if (!$hlblock) {
            throw new \RuntimeException('Highload-блок диагнозов МКБ с ID=' . $hlId . ' не найден');
        }

        $entity = HighloadBlockTable::compileEntity($hlblock);

        return $entity->getDataClass();
    }

    private static function logError(\Throwable $e): void
    {
        self::logMessage('diagnoses_import exception: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    }

    private static function logMessage(string $msg): void
    {
        if (class_exists(\Bitrix\Main\Diag\Debug::class)) {
            \Bitrix\Main\Diag\Debug::writeToFile($msg, '', '/local/logs/chemo_import.log');
        }
    }
}
