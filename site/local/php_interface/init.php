<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

// Быстрый вызов дебаггера в любом месте -
// \Bitrix\Main\Diag\Debug::dump($val);
// \Bitrix\Main\Diag\Debug::writeToFile($val, "mess", "/local/debug/".date('Y.m.d_H:i:s'));
// \Bitrix\Main\Diag\Debug::dumpToFile($val, "mess", "/local/debug/".date('Y.m.d_H:i:s'));

$connection = Bitrix\Main\Application::getConnection();
// $connection->queryExecute("SET sql_mode=''");
$connection->queryExecute("SET SESSION innodb_strict_mode=0");

date_default_timezone_set("Europe/Moscow");
ini_set("default_socket_timeout", 600);
ini_set("memory_limit", '1024M');

// Константы для скриптов
define('ONESUSER', 'wsuser');
define('ONESPWD', '456qwe');

define('CLINICS_GUID', [
    'e75d8aab-9952-11ec-80fe-002590c014a5', // Болотниковская
]);

// external composer
// if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/../../vendor/autoload.php")) {

//     require_once $_SERVER["DOCUMENT_ROOT"] . "/../../vendor/autoload.php";
// }

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/.settings.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/.settings.php';
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/guide_legacy_redirects.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/guide_legacy_redirects.php';
}

// Подключение файла с классом параметров
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/ParamsClass.php")) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/ParamsClass.php";
}

// Подключение файла с обработчиками событий
// if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/Events.php")) {
// require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/Events.php";
// }

// Подключение файла с классом
if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/AjaxClass.php")) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/AjaxClass.php";
}

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/schedule_v2.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/schedule_v2.php';
}

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/ChemotherapySchemesImport.php")) {
    require_once $_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/ChemotherapySchemesImport.php";
}

define('HL_SHORT_LINKS_ID', 3); // ID Highload-блока коротких ссылок для sms
define('HL_CHEMO_SCHEMES_ID', 4); // ID Highload-блока cхем ХТ
define('HL_DIAGNOSES_MKB_ID', 5);  // ID Highload-блока диагнозы МКБ

/**
 * Токен для API создания короткой ссылки (POST /ajax/index.php?action=short_link_create).
 * Заголовок X-Short-Link-Token: <токен>. Пустая строка — проверка отключена.
 */
define('SHORT_LINK_API_TOKEN', 'gsw*Q8pIUAyK$o3Je9kF71TfLwfPVb!x');



if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/AgentHeartbeatLogger.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/AgentHeartbeatLogger.php';
}

