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

$map = [
    'Онкогинекологические заболевания' => [
        'replace' => [
            'Рак шейки матки' => 'https://hemonc.ru/services/treatment/chemotherapy/rak-sheiki-matki/',
            'Рак яичников'    => 'https://hemonc.ru/services/treatment/chemotherapy/rak-iaichnikov/',
        ],
        'add' => [
            'Рак матки' => 'https://hemonc.ru/services/treatment/chemotherapy/lechenie-raka-matki/',
            'Рак эндометрия (тела матки)' =>
                'https://hemonc.ru/services/treatment/chemotherapy/rak-endometriia-tela-matki/',
        ],
    ],

    'Онкологические заболевания органов ЖКТ' => [
        'replace' => [
            'Рак желудка' => 'https://hemonc.ru/services/treatment/chemotherapy/rak-zheludka/',
            'Рак поджелудочной железы' =>
                'https://hemonc.ru/services/treatment/chemotherapy/rak-podzheludochnoi-zhelezy/',
        ],
        'add' => [
            'Рак кишечника' => 'https://hemonc.ru/services/treatment/chemotherapy/rak-kishechnika/',
        ],
    ],

    'Онкологические заболевания органов грудной клетки' => [
        'replace' => [
            'Рак легких' => 'https://hemonc.ru/services/treatment/chemotherapy/rak-legkikh/',
        ],
    ],

    'Онкоурологические заболевания' => [
        'replace' => [
            'Рак мочевого пузыря' =>
                'https://hemonc.ru/services/treatment/chemotherapy/lechenie-raka-mochevogo-puzyria/',
        ],
    ],
];


foreach ($arResult['SECTIONS'] as &$section) {

    if (empty($map[$section['NAME']])) {
        continue;
    }

    $config = $map[$section['NAME']];

    // Замены
    if (!empty($config['replace'])) {
        foreach ($section['ITEMS'] as &$item) {
            if (isset($config['replace'][$item['NAME']])) {
                $item['DETAIL_PAGE_URL'] = $config['replace'][$item['NAME']];
                $item['DETAIL_TEXT'] = '1';
            }
        }
        unset($item);
    }

    // Добавления
    if (!empty($config['add'])) {
        foreach ($config['add'] as $name => $url) {
            $section['ITEMS'][] = [
                'ID' => 'custom_' . md5($name),
                'NAME' => $name,
                'DETAIL_PAGE_URL' => $url,
                'DETAIL_TEXT' => '1',
                'PREVIEW_TEXT' => '',
                'PROPERTIES' => [],
            ];
        }
    }
}
unset($section);


// Новый раздел — Опухоли головы и шеи
$arResult['SECTIONS'][] = [
    'ID' => 'custom_head_neck',
    'NAME' => 'Опухоли головы и шеи',
    'ITEMS' => [
        [
            'ID' => 'custom_head_neck_cancer',
            'NAME' => 'Рак головы и шеи',
            'DETAIL_PAGE_URL' =>
                'https://hemonc.ru/services/treatment/chemotherapy/rak-golovy-i-shei/',
            'DETAIL_TEXT' => '1',
            'PREVIEW_TEXT' => '',
            'PROPERTIES' => [],
        ],
    ],
    'SECTIONS' => [],
];
