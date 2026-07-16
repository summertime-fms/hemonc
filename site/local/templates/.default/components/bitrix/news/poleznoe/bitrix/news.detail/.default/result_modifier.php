<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

$arResult['OTHER_FEEDS'] = [];
$rsOtherFeeds            = \CIBlockElement::GetList(
    [
        "DATE_ACTIVE_FROM" => "DESC",
    ],
    [
        "IBLOCK_ID" => $arResult['IBLOCK_ID'],
    ],
    false,
    [
        "nTopCount" => 25,
    ],
    [
        'ID',
        'CODE',
        'NAME',
        'DETAIL_PAGE_URL',
        'DATE_ACTIVE_FROM',
    ],
);

while ($arOtherFeed = $rsOtherFeeds->getNext()) {
    $arOtherFeed["DISPLAY_ACTIVE_FROM"] = \CIBlockFormatProperties::DateFormat(
        $arParams["ACTIVE_DATE_FORMAT"],
        MakeTimeStamp($arOtherFeed["ACTIVE_FROM"], \CSite::GetDateFormat())
    );
    $arResult['OTHER_FEEDS'][] = $arOtherFeed;
}

$arResult['ARTICLE_DOCTOR'] = false;
$arResult['ARTICLE_SOURCES'] = [];

$doctorProp = $arResult['PROPERTIES']['ARTICLE_DOCTOR'] ?? null;
if (is_array($doctorProp) && !empty($doctorProp['VALUE'])) {
    $doctor = \CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => (int) ($doctorProp['LINK_IBLOCK_ID'] ?? 15),
            'ID'        => (int) $doctorProp['VALUE'],
            'ACTIVE'    => 'Y',
        ],
        false,
        false,
        [
            'ID',
            'NAME',
            'PREVIEW_PICTURE',
            'DETAIL_PAGE_URL',
            'PROPERTY_FIRST_NAME',
            'PROPERTY_MID_NAME',
            'PROPERTY_TITLE',
            'PROPERTY_TITLE2',
        ],
    )->GetNext();

    if (is_array($doctor)) {
        $photoId = (int) ($doctor['PREVIEW_PICTURE'] ?? 0);
        $doctor['PHOTO_SRC'] = $photoId > 0 ? (string) \CFile::GetPath($photoId) : '';
        $doctor['FULL_NAME'] = trim(implode(' ', array_filter([
            trim((string) ($doctor['PROPERTY_FIRST_NAME_VALUE'] ?? '')),
            trim((string) ($doctor['PROPERTY_MID_NAME_VALUE'] ?? '')),
            trim((string) ($doctor['NAME'] ?? '')),
        ])));
        $doctor['POSITION'] = trim((string) ($doctor['PROPERTY_TITLE_VALUE'] ?? ''));
        $doctor['EXPERIENCE'] = trim((string) ($doctor['PROPERTY_TITLE2_VALUE'] ?? ''));

        $arResult['ARTICLE_DOCTOR'] = $doctor;
    }
}

$sourcesProp = $arResult['PROPERTIES']['ARTICLE_SOURCES'] ?? null;
if (is_array($sourcesProp) && !empty($sourcesProp['VALUE'])) {
    $values = $sourcesProp['VALUE'];
    $descriptions = $sourcesProp['DESCRIPTION'] ?? [];

    if (!is_array($values)) {
        $values = [$values];
    }
    if (!is_array($descriptions)) {
        $descriptions = [$descriptions];
    }

    foreach ($values as $index => $url) {
        $url = trim((string) $url);
        if ($url === '') {
            continue;
        }

        $title = trim((string) ($descriptions[$index] ?? ''));
        if ($title === '') {
            $host = (string) parse_url($url, PHP_URL_HOST);
            $title = preg_replace('/^www\./', '', $host) ?: $url;
        }

        $arResult['ARTICLE_SOURCES'][] = [
            'TITLE' => $title,
            'URL'   => $url,
        ];
    }
}
