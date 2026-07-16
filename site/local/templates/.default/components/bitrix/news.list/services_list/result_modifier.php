<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

$arFilter = [
    'IBLOCK_ID' => $arResult['ID'],
    'ACTIVE' => 'Y',
    'GLOBAL_ACTIVE' => 'Y',
];

if (
    isset($arParams['PARENT_SECTION'])
    && $arParams['PARENT_SECTION'] > 0
) {
    $arFilter['IBLOCK_SECTION_ID'] = $arParams['PARENT_SECTION'];
}

$arResult['rsSections'] = \Bitrix\Iblock\SectionTable::getList([
    'filter' => $arFilter,
    'select' => [
        'ID',
        'NAME',
        'CODE',
        'DEPTH_LEVEL',
    ],
    'order' => [
        'LEFT_MARGIN'=>'ASC',
        'SORT' => 'ASC',
    ],
])->fetchAll();

$arResult['SECTIONS'] = [];

foreach ($arResult['rsSections'] as $arSection) {
    if ($arSection['DEPTH_LEVEL'] == 1) {
        $currentRoot = $arSection['ID'];
        $arResult['SECTIONS'][$arSection['ID']] = $arSection;
        foreach ($arResult["ITEMS"] as $arItem) {
            if ($arItem['IBLOCK_SECTION_ID'] == $arSection['ID']) {
                $arResult['SECTIONS'][$arSection['ID']]['ITEMS'][] = $arItem;
            }
        }
    } else {
        $arResult['SECTIONS'][$currentRoot]['SECTIONS'][$arSection['ID']] = $arSection;
        foreach ($arResult["ITEMS"] as $arItem) {
            if ($arItem['IBLOCK_SECTION_ID'] == $arSection['ID']) {
                $arResult['SECTIONS'][$currentRoot]['SECTIONS'][$arSection['ID']]['ITEMS'][] = $arItem;
            }
        }
    }
}
