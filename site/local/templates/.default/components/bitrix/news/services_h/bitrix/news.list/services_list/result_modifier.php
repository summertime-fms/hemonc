<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2023
 */

$arFilter = [
    'IBLOCK_ID'       => $arResult['ID'],
    'ACTIVE'          => 'Y',
    'GLOBAL_ACTIVE'   => 'Y',
    'UF_SHOW_IN_ROOT' => 1,
];

if (
    isset($arParams['PARENT_SECTION'])
    && $arParams['PARENT_SECTION'] > 0
) {
    $arFilter['IBLOCK_SECTION_ID'] = $arParams['PARENT_SECTION'];
}

$arResult['rsSections'] = \CIBlockSection::GetList(
    [
        'LEFT_MARGIN' => 'ASC',
        'SORT'        => 'ASC',
    ],
    $arFilter,
    false,
    [
        'ID',
        'NAME',
        'CODE',
        'DEPTH_LEVEL',
        'SECTION_PAGE_URL',
        'UF_*',
    ],
);

while ($arSection = $arResult['rsSections']->GetNext()) {
    $arResult['ITEMS'][] = [
        'DETAIL_PAGE_URL' => $arSection['SECTION_PAGE_URL'],
        'NAME'            => $arSection['NAME'],
        'PROPERTIES'      => [
            'LABEL' => [
                'VALUE' => $arSection['UF_TEXT_IN_ROOT'],
            ],
        ],
    ];
}
