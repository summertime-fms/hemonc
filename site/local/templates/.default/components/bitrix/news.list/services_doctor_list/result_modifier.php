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

foreach ($arResult['rsSections'] as $k => $arSection) {
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

foreach ($arResult['SECTIONS'] as $k => $section) {
    foreach ($section['SECTIONS'] as $k1 => $subSection) {
        if (
            !isset($subSection['ITEMS'])
            || count($subSection['ITEMS']) == 0
        ) {
            unset(
                $arResult['SECTIONS'][$k]['SECTIONS'][$k1],
                $section['SECTIONS'][$k1],
            );
        }
    }

    if (
        (
            !isset($section['SECTIONS'])
            || count($section['SECTIONS']) == 0
        )
        &&
        (
            !isset($section['ITEMS'])
            || count($section['ITEMS']) == 0
        )
    ) {
        // unset($arResult['SECTIONS'][$k]);
    }
}