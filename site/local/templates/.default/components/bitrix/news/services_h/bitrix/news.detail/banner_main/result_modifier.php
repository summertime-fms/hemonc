<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2023
 */

if ($arResult['PROPERTIES']['BANNER_PICTURE']['VALUE']) {
    $arResult['PROPERTIES']['BANNER_PICTURE'] = [
        'SRC' => \CFile::GetPath($arResult['PROPERTIES']['BANNER_PICTURE']['VALUE']),
        'ID'  => $arResult['PROPERTIES']['BANNER_PICTURE']['VALUE'],
    ];
}

$arResult['BANNER_TITLE']    = false;
$arResult['BANNER_SUBTITLE'] = false;

if ($arResult['PROPERTIES']['BANNER_TITLE']['VALUE']) {
    $arResult['BANNER_TITLE'] = $arResult['PROPERTIES']['BANNER_TITLE']['VALUE'];
}

if ($arResult['PROPERTIES']['BANNER_SUBTITLE']['VALUE']) {
    $arResult['BANNER_SUBTITLE'] = $arResult['PROPERTIES']['BANNER_SUBTITLE']['VALUE'];
}
