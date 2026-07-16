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
