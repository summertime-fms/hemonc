<?php
declare(strict_types=1);

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;

header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (PHP_SAPI === 'cli' && isset($_SERVER['argv']) && is_array($_SERVER['argv'])) {
    foreach (array_slice($_SERVER['argv'], 1) as $arg) {
        if (!is_string($arg) || strpos($arg, '=') === false) {
            continue;
        }
        [$k, $v] = explode('=', $arg, 2);
        $k = trim($k);
        if ($k !== '') {
            $_REQUEST[$k] = $v;
        }
    }
}

$docRootCandidates = [];
$serverDocRoot = trim((string)($_SERVER['DOCUMENT_ROOT'] ?? ''));
if ($serverDocRoot !== '') {
    $docRootCandidates[] = $serverDocRoot;
}
$cwd = getcwd();
if (is_string($cwd) && $cwd !== '') {
    $docRootCandidates[] = $cwd;
}
$docRootCandidates[] = __DIR__;
$docRootCandidates[] = dirname(__DIR__);
$docRootCandidates[] = dirname(__DIR__, 2);

$resolvedDocRoot = null;
foreach ($docRootCandidates as $candidate) {
    $candidate = rtrim((string)$candidate, '/');
    if ($candidate === '') {
        continue;
    }
    $real = realpath($candidate);
    if ($real === false) {
        continue;
    }
    if (is_file($real . '/bitrix/modules/main/include/prolog_before.php')) {
        $resolvedDocRoot = $real;
        break;
    }
}

if ($resolvedDocRoot === null) {
    http_response_code(500);
    echo 'Не удалось определить DOCUMENT_ROOT (не найден bitrix/modules/main/include/prolog_before.php)';
    exit(1);
}

$_SERVER['DOCUMENT_ROOT'] = $resolvedDocRoot;

define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/init.php';

if (!Loader::includeModule('iblock') || !Loader::includeModule('highloadblock')) {
    http_response_code(500);
    echo 'Не удалось подключить модули iblock/highloadblock';
    exit(1);
}

$servicesIblockId = (int)($_REQUEST['services_iblock_id'] ?? 20);
$hlId = (int)($_REQUEST['hl_id'] ?? (defined('HL_DIAGNOSES_MKB_ID') ? (int)HL_DIAGNOSES_MKB_ID : 0));
$csvPath = (string)($_REQUEST['csv'] ?? (getcwd() . '/results.csv'));
$dryRun = (string)($_REQUEST['dry_run'] ?? '1') === '1';

if ($servicesIblockId <= 0 || $hlId <= 0) {
    http_response_code(400);
    echo 'Некорректные services_iblock_id/hl_id';
    exit(1);
}
if (!is_file($csvPath)) {
    http_response_code(404);
    echo 'CSV файл не найден: ' . htmlspecialchars($csvPath, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    exit(1);
}

$normalizeCode = static function (string $code): string {
    $code = mb_strtoupper(trim($code));
    $code = strtr($code, [
        'А' => 'A',
        'В' => 'B',
        'С' => 'C',
        'Е' => 'E',
        'К' => 'K',
        'М' => 'M',
        'Н' => 'H',
        'О' => 'O',
        'Р' => 'P',
        'Т' => 'T',
        'Х' => 'X',
    ]);

    return preg_replace('/\s+/', '', $code) ?? '';
};

$hl = HighloadBlockTable::getById($hlId)->fetch();
if (!$hl) {
    http_response_code(404);
    echo 'HL-блок не найден: ID=' . $hlId;
    exit(1);
}

$entity = HighloadBlockTable::compileEntity($hl);
$hlDataClass = $entity->getDataClass();

$hlIdByCode = [];
$hlRes = $hlDataClass::getList([
    'select' => ['ID', 'UF_MKB_CODE', 'UF_XML_ID'],
    'order' => ['ID' => 'ASC'],
]);
while ($row = $hlRes->fetch()) {
    $id = (int)($row['ID'] ?? 0);
    if ($id <= 0) {
        continue;
    }
    $code = $normalizeCode((string)($row['UF_MKB_CODE'] ?? ''));
    if ($code === '') {
        $code = $normalizeCode((string)($row['UF_XML_ID'] ?? ''));
    }
    if ($code === '') {
        continue;
    }
    $hlIdByCode[$code] = $id;
}

$serviceCodes = []; // SERVICE_ID => [CODE => true]
$fp = fopen($csvPath, 'rb');
if ($fp === false) {
    http_response_code(500);
    echo 'Не удалось открыть CSV: ' . htmlspecialchars($csvPath, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    exit(1);
}

$header = fgetcsv($fp);
if (!is_array($header)) {
    fclose($fp);
    http_response_code(400);
    echo 'CSV пустой или поврежден';
    exit(1);
}
$headerMap = [];
foreach ($header as $idx => $name) {
    $headerMap[trim((string)$name)] = (int)$idx;
}

if (!isset($headerMap['SERVICE_ID']) || !isset($headerMap['DIAGNOSIS_MKB_CODE'])) {
    fclose($fp);
    http_response_code(400);
    echo 'CSV должен содержать колонки SERVICE_ID и DIAGNOSIS_MKB_CODE';
    exit(1);
}

while (($row = fgetcsv($fp)) !== false) {
    if (!is_array($row)) {
        continue;
    }
    $serviceId = (int)($row[$headerMap['SERVICE_ID']] ?? 0);
    $mkbRaw = (string)($row[$headerMap['DIAGNOSIS_MKB_CODE']] ?? '');
    $code = $normalizeCode($mkbRaw);
    if ($serviceId <= 0 || $code === '') {
        continue;
    }
    $serviceCodes[$serviceId][$code] = true;
}
fclose($fp);

$serviceUpdated = 0;
$servicesNotFound = [];
$missingCodes = [];
$errors = [];

foreach ($serviceCodes as $serviceId => $codesSet) {
    $serviceExists = \CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => $servicesIblockId, 'ID' => (int)$serviceId],
        false,
        false,
        ['ID']
    )->Fetch();

    if (!$serviceExists) {
        $servicesNotFound[] = (int)$serviceId;
        continue;
    }

    $newValues = [];
    foreach (array_keys($codesSet) as $code) {
        if (!isset($hlIdByCode[$code])) {
            $missingCodes[$code][] = (int)$serviceId;
            continue;
        }
        $newValues[] = (string)$hlIdByCode[$code];
    }

    $newValues = array_values(array_unique($newValues));
    if ($newValues === []) {
        continue;
    }

    if (!$dryRun) {
        try {
            \CIBlockElement::SetPropertyValuesEx((int)$serviceId, $servicesIblockId, ['DIAGNOSIS' => $newValues]);
        } catch (\Throwable $e) {
            $errors[] = 'SERVICE_ID=' . $serviceId . ': ' . $e->getMessage();
            continue;
        }
    }
    $serviceUpdated++;
}

echo '<h3>Восстановление связей услуг с диагнозами завершено</h3>';
if ($dryRun) {
    echo '<p style="color:#b45309;"><b>Режим dry_run=1:</b> изменения НЕ применялись.</p>';
}
echo '<pre>';
print_r([
    'ok' => $errors === [],
    'services_iblock_id' => $servicesIblockId,
    'hl_id' => $hlId,
    'csv' => $csvPath,
    'dry_run' => $dryRun,
    'services_from_csv' => count($serviceCodes),
    'services_updated' => $serviceUpdated,
    'services_not_found_count' => count($servicesNotFound),
    'services_not_found' => $servicesNotFound,
    'missing_mkb_codes_count' => count($missingCodes),
    'missing_mkb_codes' => $missingCodes,
    'errors_count' => count($errors),
    'errors' => $errors,
]);
echo '</pre>';
