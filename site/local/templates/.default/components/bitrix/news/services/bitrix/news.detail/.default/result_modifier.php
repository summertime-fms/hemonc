<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = \Bitrix\Main\Context::getCurrent()->getRequest();

$arResult['DOCTORS'] = [];
if (isset($arResult['PROPERTIES']['DOCTORS']['VALUE']) && !empty($arResult['PROPERTIES']['DOCTORS']['VALUE'])) {
    $rsDoctors = \CIBlockElement::GetList(
        [
            "PROPERTY_SERVICES_SORT" => "ASC",
        ],
        [
            "IBLOCK_ID" => $arResult['PROPERTIES']['DOCTORS']['LINK_IBLOCK_ID'],
            "ID"        => $arResult['PROPERTIES']['DOCTORS']['VALUE'],
        ],
        false,
        false,
        [
            'ID',
            'CODE',
            'NAME',
            'PREVIEW_PICTURE',
            'PROPERTY_MID_NAME',
            'PROPERTY_FIRST_NAME',
            'PROPERTY_TITLE',
            'PROPERTY_PRICE_CLINIC',
            'PROPERTY_PRICE_ONLINE',
            'PROPERTY_ONES_GUID',
            'DETAIL_PAGE_URL',
        ],
    );

    while ($arDoctor = $rsDoctors->getNext()) {
        $arDoctor['PREVIEW_PICTURE'] = [
            'SRC' => \CFile::GetPath($arDoctor["PREVIEW_PICTURE"]),
            'ID'  => $arDoctor['PREVIEW_PICTURE'],
        ];

        $arDoctor['FULL_NAME'] = $arDoctor['NAME'] . ' ' . $arDoctor['PROPERTY_FIRST_NAME_VALUE'] . ' ' . $arDoctor['PROPERTY_MID_NAME_VALUE'];

        if (
            isset($arDoctor["PROPERTY_ONES_GUID_VALUE"])
            && !empty($arDoctor["PROPERTY_ONES_GUID_VALUE"])
        ) {
            if (array_key_exists($arDoctor["PROPERTY_ONES_GUID_VALUE"], $arParams['nearestTimeWeekAll'])) {
                $arDoctor['schedule'] = $arParams['nearestTimeWeekAll'][$arDoctor["PROPERTY_ONES_GUID_VALUE"]];
            }
        }

        $arResult['DOCTORS'][$arDoctor['ID']] = $arDoctor;
    }
}

$arResult['currentDoc'] = false;

if (
    isset($request["doctor"])
    && isset($arResult['DOCTORS'][intval($request["doctor"])])
) {
    $arResult['currentDoc'] = $arResult['DOCTORS'][intval($request["doctor"])];
} 

$arResult['OTHER_FEEDS'] = [];
$rsOtherFeeds            = \CIBlockElement::GetList(
    [
        "RAND" => "ASC",
    ],
    [
        "IBLOCK_ID" => 16,
    ],
    false,
    [
        "nTopCount" => 30,
    ],
    [
        'ID',
        'CODE',
        'NAME',
        'DETAIL_PAGE_URL',
        'DATE_ACTIVE_FROM'
    ],
);

while ($arOtherFeed = $rsOtherFeeds->getNext()) {
    $arOtherFeed["DISPLAY_ACTIVE_FROM"] = \CIBlockFormatProperties::DateFormat(
        $arParams["ACTIVE_DATE_FORMAT"],
        MakeTimeStamp($arOtherFeed["ACTIVE_FROM"], \CSite::GetDateFormat())
    );
    $arResult['OTHER_FEEDS'][] = $arOtherFeed;
}

$pricePropertyExplode = explode('-', $arResult['PROPERTIES']['PRICE']['VALUE'] ?? '');

$arResult['PROPERTIES']['PRICE']['MIN_VALUE'] = isset($pricePropertyExplode[0]) ? preg_replace('/[^0-9]/', '', trim($pricePropertyExplode[0])) : false;
$arResult['PROPERTIES']['PRICE']['MAX_VALUE'] = isset($pricePropertyExplode[1]) ? preg_replace('/[^0-9]/', '', trim($pricePropertyExplode[1])) : false;
