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
$outPath = (string)($_REQUEST['out'] ?? (getcwd() . '/services_diagnosis_links.csv'));

if ($servicesIblockId <= 0) {
    http_response_code(400);
    echo 'Неверный services_iblock_id';
    exit(1);
}
if ($hlId <= 0) {
    http_response_code(400);
    echo 'Неверный hl_id';
    exit(1);
}

$hl = HighloadBlockTable::getById($hlId)->fetch();
if (!$hl) {
    http_response_code(404);
    echo 'HL-блок не найден: ID=' . $hlId;
    exit(1);
}

$entity = HighloadBlockTable::compileEntity($hl);
$hlDataClass = $entity->getDataClass();

$hlById = [];
$hlByXml = [];
$hlRows = $hlDataClass::getList([
    'select' => ['ID', 'UF_MKB_CODE', 'UF_XML_ID', 'UF_NAME', 'UF_SHORTNAME'],
    'order' => ['ID' => 'ASC'],
]);
while ($row = $hlRows->fetch()) {
    $id = (int)($row['ID'] ?? 0);
    if ($id <= 0) {
        continue;
    }
    $hlById[$id] = $row;
    $xml = trim((string)($row['UF_XML_ID'] ?? ''));
    if ($xml !== '') {
        $hlByXml[$xml] = $row;
    }
}

$rows = [];
$serviceRes = \CIBlockElement::GetList(
    ['ID' => 'ASC'],
    ['IBLOCK_ID' => $servicesIblockId, 'ACTIVE' => 'Y'],
    false,
    false,
    ['ID', 'IBLOCK_ID', 'NAME', 'XML_ID', 'CODE']
);
while ($service = $serviceRes->Fetch()) {
    $serviceId = (int)($service['ID'] ?? 0);
    if ($serviceId <= 0) {
        continue;
    }

    $propRes = \CIBlockElement::GetProperty(
        $servicesIblockId,
        $serviceId,
        ['sort' => 'asc', 'id' => 'asc'],
        ['CODE' => 'DIAGNOSIS']
    );

    while ($prop = $propRes->Fetch()) {
        $raw = $prop['VALUE'] ?? $prop['~VALUE'] ?? '';
        if (is_array($raw)) {
            $raw = $raw['ID'] ?? reset($raw);
        }
        $raw = trim((string)$raw);
        if ($raw === '') {
            continue;
        }

        $hlRow = null;
        if (preg_match('/^\d+$/', $raw)) {
            $hlRow = $hlById[(int)$raw] ?? null;
        }
        if ($hlRow === null) {
            $hlRow = $hlByXml[$raw] ?? null;
        }

        $rows[] = [
            'SERVICE_ID' => $serviceId,
            'SERVICE_NAME' => (string)($service['NAME'] ?? ''),
            'SERVICE_XML_ID' => (string)($service['XML_ID'] ?? ''),
            'DIAGNOSIS_RAW' => $raw,
            'DIAGNOSIS_HL_ID' => (string)($hlRow['ID'] ?? ''),
            'DIAGNOSIS_MKB_CODE' => (string)($hlRow['UF_MKB_CODE'] ?? ''),
            'DIAGNOSIS_UF_XML_ID' => (string)($hlRow['UF_XML_ID'] ?? ''),
            'DIAGNOSIS_UF_NAME' => (string)($hlRow['UF_NAME'] ?? ''),
            'DIAGNOSIS_UF_SHORTNAME' => (string)($hlRow['UF_SHORTNAME'] ?? ''),
        ];
    }
}

$dir = dirname($outPath);
if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
    http_response_code(500);
    echo 'Не удалось создать директорию для файла: ' . htmlspecialchars($dir, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    exit(1);
}

$fp = fopen($outPath, 'wb');
if ($fp === false) {
    http_response_code(500);
    echo 'Не удалось открыть файл для записи: ' . htmlspecialchars($outPath, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    exit(1);
}

$header = [
    'SERVICE_ID',
    'SERVICE_NAME',
    'SERVICE_XML_ID',
    'DIAGNOSIS_RAW',
    'DIAGNOSIS_HL_ID',
    'DIAGNOSIS_MKB_CODE',
    'DIAGNOSIS_UF_XML_ID',
    'DIAGNOSIS_UF_NAME',
    'DIAGNOSIS_UF_SHORTNAME',
];
fputcsv($fp, $header);
foreach ($rows as $row) {
    fputcsv($fp, $row);
}
fclose($fp);

echo '<h3>Выгрузка связей услуг с диагнозами завершена</h3>';
echo '<pre>';
print_r([
    'ok' => true,
    'services_iblock_id' => $servicesIblockId,
    'hl_id' => $hlId,
    'rows' => count($rows),
    'out' => $outPath,
]);
echo '</pre>';
