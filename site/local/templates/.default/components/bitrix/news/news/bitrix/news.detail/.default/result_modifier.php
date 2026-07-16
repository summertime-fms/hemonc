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
