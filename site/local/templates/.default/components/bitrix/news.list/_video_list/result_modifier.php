<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

$arResult['rsSections'] = \Bitrix\Iblock\SectionTable::getList([
    'filter' => [
        'IBLOCK_ID' => $arResult['ID'],
    ],
    'select' => [
        'ID',
        'NAME',
        'CODE',
    ],
    'order' => [
        'SORT' => 'ASC',
    ]
])->fetchAll();

foreach ($arResult['rsSections'] as $arSection) {  
    foreach ($arResult["ITEMS"] as $arItem) {
        if ($arItem['IBLOCK_SECTION_ID'] == $arSection['ID']){
            $arSection['ELEMENTS'][] =  $arItem;
        }
    }
    @$arElementGroups[] = $arSection;
}

$arResult["ITEMS"] = $arElementGroups;
