<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2023
 */

$cp = $this->__component;

$arFilter = [
    'IBLOCK_ID'     => 22,
    'ACTIVE'        => 'Y',
    'GLOBAL_ACTIVE' => 'Y',
];

if (
    isset($arParams['PARENT_SECTION'])
    && $arParams['PARENT_SECTION'] > 0
) {
    $arFilter['IBLOCK_SECTION_ID'] = $arParams['PARENT_SECTION'];
    $arResult['curSect']           = \CIBlockSection::GetByID($arParams['PARENT_SECTION'])->getNext();
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
        'LEFT_MARGIN' => 'ASC',
        'SORT'        => 'ASC',
    ],
])->fetchAll();

$arResult['SECTIONS'][$arResult['curSect']['ID']]          = $arResult['curSect'];
$arResult['SECTIONS'][$arResult['curSect']['ID']]['ITEMS'] = [];

if (count($arResult['rsSections']) == 0) {
    $arResult['SECTIONS'][$arResult['curSect']['ID']]['ITEMS'] = $arResult["ITEMS"];
} else {
    foreach ($arResult['rsSections'] as $arSection) {
        $arResult['SECTIONS'][$arSection['ID']] = $arSection;
        foreach ($arResult["ITEMS"] as $arItem) {
            if ($arItem['IBLOCK_SECTION_ID'] == $arSection['ID']) {
                $arResult['SECTIONS'][$arSection['ID']]['ITEMS'][] = $arItem;
            } elseif ($arItem['IBLOCK_SECTION_ID'] == $arResult['curSect']['ID']) {
                $arResult['SECTIONS'][$arResult['curSect']['ID']]['ITEMS'][$arItem['ID']] = $arItem;
            }
        }
    }
}

$arResult['curSect_DESCRIPTION'] = $arResult['curSect']['DESCRIPTION'];

if (is_object($cp)) {
    $cp->SetResultCacheKeys([
        'curSect_DESCRIPTION',
    ]);
}
