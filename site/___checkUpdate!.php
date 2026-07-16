<?php

if(!file_exists($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php')){
    http_response_code(404);
    exit();
}

use Bitrix\Main\Loader;

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

Loader::includeModule('main');

$error = null;

$arUpdates = \CUpdateClient::GetUpdatesList(
    $error,
    "Y",
    [],
    "Y"
);

//echo '<pre>';
//print_r([
//    'error' => $error,
//    'updates' => $arUpdates,
//]);
//echo '</pre>';

echo !empty($arUpdates['CLIENT'][0]['@']['DATE_TO_SOURCE']) ?
    json_encode(['date' => $arUpdates['CLIENT'][0]['@']['DATE_TO_SOURCE']]) : null;
exit;
