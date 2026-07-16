<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2023
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);

$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "page_text",
    [
        "ACTIVE_DATE_FORMAT"        => "j F Y",
        "ADD_ELEMENT_CHAIN"         => "N",
        "ADD_SECTIONS_CHAIN"        => "N",
        "AJAX_MODE"                 => "N",
        "AJAX_OPTION_ADDITIONAL"    => "",
        "AJAX_OPTION_HISTORY"       => "N",
        "AJAX_OPTION_JUMP"          => "N",
        "AJAX_OPTION_STYLE"         => "N",
        "BROWSER_TITLE"             => "TITLE",
        "CACHE_GROUPS"              => "N",
        "CACHE_TIME"                => "36000000",
        "CACHE_TYPE"                => "A",
        "CHECK_DATES"               => "Y",
        "COMPOSITE_FRAME_MODE"      => "A",
        "COMPOSITE_FRAME_TYPE"      => "AUTO",
        "ELEMENT_CODE"              => "services",
        "ELEMENT_ID"                => "",
        "FIELD_CODE"                => [],
        "IBLOCK_ID"                 => "7",
        "IBLOCK_TYPE"               => "site",
        "IBLOCK_URL"                => "",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "MESSAGE_404"               => "",
        "META_DESCRIPTION"          => "DESCRIPTION",
        "PROPERTY_CODE"             => [],
        "SET_BROWSER_TITLE"         => "N",
        "SET_CANONICAL_URL"         => "N",
        "SET_LAST_MODIFIED"         => "N",
        "SET_META_DESCRIPTION"      => "N",
        "SET_META_KEYWORDS"         => "N",
        "SET_STATUS_404"            => "N",
        "SET_TITLE"                 => "N",
        "SHOW_404"                  => "N",
        "STRICT_SECTION_CHECK"      => "N",
        "USE_PERMISSIONS"           => "N",
        "CSS_CLASS_BODY"            => "services-page",
        "CSS_CLASS_HEADER"          => "default-main-block-header full-width",
        "HEADER_TEXT_CONTAINER"     => "",
    ],
);

$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "navigation",
    [
        "IBLOCK_TYPE"               => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID"                 => $arParams["IBLOCK_ID"],
        "PROPERTY_CODE"             => $arParams["DETAIL_PROPERTY_CODE"],
        "SET_META_DESCRIPTION"      => "N",
        "SET_CANONICAL_URL"         => 'N',
        "SET_BROWSER_TITLE"         => "N",
        "SET_TITLE"                 => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => 'N',
        "ADD_SECTIONS_CHAIN"        => 'N',
        "CACHE_TYPE"                => $arParams["CACHE_TYPE"],
        "CACHE_TIME"                => $arParams["CACHE_TIME"],
        "CACHE_GROUPS"              => $arParams["CACHE_GROUPS"],
        "ELEMENT_ID"                => $arResult["VARIABLES"]["ELEMENT_ID"],
        "ELEMENT_CODE"              => $arResult["VARIABLES"]["ELEMENT_CODE"],
        "SECTION_ID"                => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE"              => $arResult["VARIABLES"]["SECTION_CODE"],
        "IBLOCK_URL"                => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
        "ADD_ELEMENT_CHAIN"         => 'N',
    ],
    $component,
);

$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "banner_main",
    [
        "IBLOCK_TYPE"               => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID"                 => $arParams["IBLOCK_ID"],
        "PROPERTY_CODE"             => $arParams["DETAIL_PROPERTY_CODE"],
        "SET_META_DESCRIPTION"      => "N",
        "SET_CANONICAL_URL"         => 'N',
        "SET_BROWSER_TITLE"         => "N",
        "SET_TITLE"                 => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => 'N',
        "ADD_SECTIONS_CHAIN"        => 'N',
        "CACHE_TYPE"                => $arParams["CACHE_TYPE"],
        "CACHE_TIME"                => $arParams["CACHE_TIME"],
        "CACHE_GROUPS"              => $arParams["CACHE_GROUPS"],
        "ELEMENT_ID"                => $arResult["VARIABLES"]["ELEMENT_ID"],
        "ELEMENT_CODE"              => $arResult["VARIABLES"]["ELEMENT_CODE"],
        "SECTION_ID"                => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE"              => $arResult["VARIABLES"]["SECTION_CODE"],
        "IBLOCK_URL"                => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
        "ADD_ELEMENT_CHAIN"         => 'N',
        'SHOW_BANNER_TITLE'         => 'Y',
        'SHOW_BANNER_SUBTITLE'      => 'N',
    ],
    $component,
);

$ElementID = $APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "",
    [
        "DISPLAY_DATE"              => 'Y',
        "DISPLAY_NAME"              => $arParams["DISPLAY_NAME"],
        "DISPLAY_PICTURE"           => $arParams["DISPLAY_PICTURE"],
        "DISPLAY_PREVIEW_TEXT"      => $arParams["DISPLAY_PREVIEW_TEXT"],
        "IBLOCK_TYPE"               => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID"                 => $arParams["IBLOCK_ID"],
        "FIELD_CODE"                => $arParams["DETAIL_FIELD_CODE"],
        "PROPERTY_CODE"             => $arParams["DETAIL_PROPERTY_CODE"],
        "DETAIL_URL"                => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
        "SECTION_URL"               => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
        "META_DESCRIPTION"          => 'DESCRIPTION',
        "SET_META_DESCRIPTION"      => "Y",
        "BROWSER_TITLE"             => "TITLE",
        "SET_CANONICAL_URL"         => 'Y',
        "SET_LAST_MODIFIED"         => $arParams["SET_LAST_MODIFIED"],
        "SET_BROWSER_TITLE"         => "Y",
        "SET_TITLE"                 => "Y",
        "MESSAGE_404"               => $arParams["MESSAGE_404"],
        "SET_STATUS_404"            => $arParams["SET_STATUS_404"],
        "SHOW_404"                  => $arParams["SHOW_404"],
        "FILE_404"                  => $arParams["FILE_404"],
        "INCLUDE_IBLOCK_INTO_CHAIN" => 'N',
        "ADD_SECTIONS_CHAIN"        => 'Y',
        "ACTIVE_DATE_FORMAT"        => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
        "CACHE_TYPE"                => $arParams["CACHE_TYPE"],
        "CACHE_TIME"                => $arParams["CACHE_TIME"],
        "CACHE_GROUPS"              => $arParams["CACHE_GROUPS"],
        "USE_PERMISSIONS"           => $arParams["USE_PERMISSIONS"],
        "GROUP_PERMISSIONS"         => $arParams["GROUP_PERMISSIONS"],
        "DISPLAY_TOP_PAGER"         => $arParams["DETAIL_DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER"      => $arParams["DETAIL_DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE"               => $arParams["DETAIL_PAGER_TITLE"],
        "PAGER_SHOW_ALWAYS"         => "N",
        "PAGER_TEMPLATE"            => $arParams["DETAIL_PAGER_TEMPLATE"],
        "PAGER_SHOW_ALL"            => $arParams["DETAIL_PAGER_SHOW_ALL"],
        "CHECK_DATES"               => $arParams["CHECK_DATES"],
        "ELEMENT_ID"                => $arResult["VARIABLES"]["ELEMENT_ID"],
        "ELEMENT_CODE"              => $arResult["VARIABLES"]["ELEMENT_CODE"],
        "SECTION_ID"                => $arResult["VARIABLES"]["SECTION_ID"],
        "SECTION_CODE"              => $arResult["VARIABLES"]["SECTION_CODE"],
        "IBLOCK_URL"                => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
        "USE_SHARE"                 => $arParams["USE_SHARE"],
        "SHARE_HIDE"                => $arParams["SHARE_HIDE"],
        "SHARE_TEMPLATE"            => $arParams["SHARE_TEMPLATE"],
        "SHARE_HANDLERS"            => $arParams["SHARE_HANDLERS"],
        "SHARE_SHORTEN_URL_LOGIN"   => $arParams["SHARE_SHORTEN_URL_LOGIN"],
        "SHARE_SHORTEN_URL_KEY"     => $arParams["SHARE_SHORTEN_URL_KEY"],
        "ADD_ELEMENT_CHAIN"         => 'Y',
        'STRICT_SECTION_CHECK'      => $arParams['STRICT_SECTION_CHECK'],
        'nearestTimeWeekAll'        => \Hemonc\Ajax::getSchedule(),
    ],
    $component,
);

global $advantages_service_detail_filter;
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "advantages_list_h",
    [
        "COMPONENT_TEMPLATE"        => ".default",
        "IBLOCK_TYPE"               => "site",
        "IBLOCK_ID"                 => "23",
        "NEWS_COUNT"                => "17",
        "SORT_BY1"                  => "SORT",
        "SORT_ORDER1"               => "ASC",
        "SORT_BY2"                  => "SORT",
        "SORT_ORDER2"               => "ASC",
        "FILTER_NAME"               => "advantages_service_detail_filter",
        "FIELD_CODE"                => ['PREVIEW_TEXT', 'PREVIEW_PICTURE'],
        "PROPERTY_CODE"             => ['TITLE'],
        "CHECK_DATES"               => "Y",
        "AJAX_MODE"                 => "N",
        "AJAX_OPTION_JUMP"          => "N",
        "AJAX_OPTION_STYLE"         => "Y",
        "AJAX_OPTION_HISTORY"       => "N",
        "AJAX_OPTION_ADDITIONAL"    => "",
        "CACHE_TYPE"                => "N",
        "CACHE_TIME"                => "36000000",
        "CACHE_FILTER"              => "N",
        "CACHE_GROUPS"              => "N",
        "ACTIVE_DATE_FORMAT"        => "j M Y",
        "SET_TITLE"                 => "N",
        "SET_BROWSER_TITLE"         => "N",
        "SET_META_KEYWORDS"         => "N",
        "SET_META_DESCRIPTION"      => "N",
        "SET_LAST_MODIFIED"         => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN"        => "N",
        "HIDE_LINK_WHEN_NO_DETAIL"  => "N",
        "PARENT_SECTION"            => "",
        "PARENT_SECTION_CODE"       => "",
        "INCLUDE_SUBSECTIONS"       => "N",
        "STRICT_SECTION_CHECK"      => "N",
        "DISPLAY_DATE"              => "Y",
        "DISPLAY_NAME"              => "Y",
        "DISPLAY_PICTURE"           => "Y",
        "DISPLAY_PREVIEW_TEXT"      => "Y",
        "PAGER_TEMPLATE"            => "hemonc_ajax",
        "DISPLAY_TOP_PAGER"         => "N",
        "DISPLAY_BOTTOM_PAGER"      => "Y",
        "SET_STATUS_404"            => "N",
        "SHOW_404"                  => "N",
        "MESSAGE_404"               => "",
    ],
    $component,
);

$APPLICATION->ShowViewContent('service-mid-section');

global $faq_top_service_detail_filter;
if (
    !isset($faq_top_service_detail_filter['ID'])
    || empty($faq_top_service_detail_filter['ID'])
) {
    $APPLICATION->IncludeComponent(
        "bitrix:news.detail",
        "faq_bg_no",
        [
            "IBLOCK_TYPE"               => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID"                 => $arParams["IBLOCK_ID"],
            "PROPERTY_CODE"             => $arParams["DETAIL_PROPERTY_CODE"],
            "SET_META_DESCRIPTION"      => "N",
            "SET_CANONICAL_URL"         => 'N',
            "SET_BROWSER_TITLE"         => "N",
            "SET_TITLE"                 => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => 'N',
            "ADD_SECTIONS_CHAIN"        => 'N',
            "CACHE_TYPE"                => $arParams["CACHE_TYPE"],
            "CACHE_TIME"                => $arParams["CACHE_TIME"],
            "CACHE_GROUPS"              => $arParams["CACHE_GROUPS"],
            "ELEMENT_ID"                => $arResult["VARIABLES"]["ELEMENT_ID"],
            "ELEMENT_CODE"              => $arResult["VARIABLES"]["ELEMENT_CODE"],
            "SECTION_ID"                => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE"              => $arResult["VARIABLES"]["SECTION_CODE"],
            "IBLOCK_URL"                => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
            "ADD_ELEMENT_CHAIN"         => 'N',
        ],
        $component,
    );
} else {
    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "faq_bg_no",
        [
            "COMPONENT_TEMPLATE"        => ".default",
            "IBLOCK_TYPE"               => "content",
            "IBLOCK_ID"                 => "24",
            "NEWS_COUNT"                => "17",
            "SORT_BY1"                  => "SORT",
            "SORT_ORDER1"               => "ASC",
            "SORT_BY2"                  => "SORT",
            "SORT_ORDER2"               => "ASC",
            "FILTER_NAME"               => "faq_top_service_detail_filter",
            "FIELD_CODE"                => ['PREVIEW_TEXT', 'PREVIEW_PICTURE'],
            "PROPERTY_CODE"             => ['TITLE'],
            "CHECK_DATES"               => "Y",
            "AJAX_MODE"                 => "N",
            "AJAX_OPTION_JUMP"          => "N",
            "AJAX_OPTION_STYLE"         => "Y",
            "AJAX_OPTION_HISTORY"       => "N",
            "AJAX_OPTION_ADDITIONAL"    => "",
            "CACHE_TYPE"                => "N",
            "CACHE_TIME"                => "36000000",
            "CACHE_FILTER"              => "N",
            "CACHE_GROUPS"              => "N",
            "ACTIVE_DATE_FORMAT"        => "j M Y",
            "SET_TITLE"                 => "N",
            "SET_BROWSER_TITLE"         => "N",
            "SET_META_KEYWORDS"         => "N",
            "SET_META_DESCRIPTION"      => "N",
            "SET_LAST_MODIFIED"         => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN"        => "N",
            "HIDE_LINK_WHEN_NO_DETAIL"  => "N",
            "PARENT_SECTION"            => "",
            "PARENT_SECTION_CODE"       => "",
            "INCLUDE_SUBSECTIONS"       => "N",
            "STRICT_SECTION_CHECK"      => "N",
            "DISPLAY_DATE"              => "Y",
            "DISPLAY_NAME"              => "Y",
            "DISPLAY_PICTURE"           => "Y",
            "DISPLAY_PREVIEW_TEXT"      => "Y",
            "PAGER_TEMPLATE"            => "hemonc_ajax",
            "DISPLAY_TOP_PAGER"         => "N",
            "DISPLAY_BOTTOM_PAGER"      => "Y",
            "SET_STATUS_404"            => "N",
            "SHOW_404"                  => "N",
            "MESSAGE_404"               => "",
        ],
        $component,
    );
}


global $doctors_service_detail_filter;

// Получаем ID текущей услуги
$currentServiceId = $arResult["VARIABLES"]["ELEMENT_ID"];

if (empty($currentServiceId) && !empty($arResult["VARIABLES"]["ELEMENT_CODE"])) {
    if (\Bitrix\Main\Loader::includeModule('iblock')) {
        $element = CIBlockElement::GetList(
            [],
            [
                'IBLOCK_ID' => $arParams["IBLOCK_ID"],
                'CODE' => $arResult["VARIABLES"]["ELEMENT_CODE"],
                'ACTIVE' => 'Y'
            ],
            false,
            ['nTopCount' => 1],
            ['ID']
        )->Fetch();
        $currentServiceId = $element['ID'];
    }
}

if ($currentServiceId && \Bitrix\Main\Loader::includeModule('iblock')) {
    $doctorIds = [];
    $res = CIBlockElement::GetProperty(
        $arParams["IBLOCK_ID"],
        $currentServiceId,
        [],
        ['CODE' => 'DOCTORS']
    );

    while ($prop = $res->Fetch()) {
        if (!empty($prop['VALUE'])) {
            $doctorIds[] = $prop['VALUE'];
        }
    }

    if (!empty($doctorIds)) {
        $doctors_service_detail_filter = ['ID' => $doctorIds];
    } else {
        $doctors_service_detail_filter = ['ID' => 0];
    }
} else {
    $doctors_service_detail_filter = ['ID' => 0];
}
    $APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "doctors_list_h",
    [
        "COMPONENT_TEMPLATE"        => ".default",
        "IBLOCK_TYPE"               => "content",
        "IBLOCK_ID"                 => "15",
        "NEWS_COUNT"                => "30",
        "SORT_BY1"                  => "SORT",
        "SORT_ORDER1"               => "ASC",
        "SORT_BY2"                  => "SORT",
        "SORT_ORDER2"               => "ASC",
        "FILTER_NAME"               => "doctors_service_detail_filter",
        "FIELD_CODE"                => ['DETAIL_TEXT', 'DATE_ACTIVE_FROM'],
        "PROPERTY_CODE"             => ['TITLE'],
        "CHECK_DATES"               => "Y",
        "AJAX_MODE"                 => "N",
        "AJAX_OPTION_JUMP"          => "N",
        "AJAX_OPTION_STYLE"         => "Y",
        "AJAX_OPTION_HISTORY"       => "N",
        "AJAX_OPTION_ADDITIONAL"    => "",
        "CACHE_TYPE"                => "A",
        "CACHE_TIME"                => "36000000",
        "CACHE_FILTER"              => "N",
        "CACHE_GROUPS"              => "N",
        "ACTIVE_DATE_FORMAT"        => "j M Y",
        "SET_TITLE"                 => "N",
        "SET_BROWSER_TITLE"         => "N",
        "SET_META_KEYWORDS"         => "N",
        "SET_META_DESCRIPTION"      => "N",
        "SET_LAST_MODIFIED"         => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN"        => "N",
        "HIDE_LINK_WHEN_NO_DETAIL"  => "N",
        "PARENT_SECTION"            => "",
        "PARENT_SECTION_CODE"       => "",
        "INCLUDE_SUBSECTIONS"       => "N",
        "STRICT_SECTION_CHECK"      => "N",
        "DISPLAY_DATE"              => "Y",
        "DISPLAY_NAME"              => "Y",
        "DISPLAY_PICTURE"           => "Y",
        "DISPLAY_PREVIEW_TEXT"      => "Y",
        "PAGER_TEMPLATE"            => "hemonc_ajax",
        "DISPLAY_TOP_PAGER"         => "N",
        "DISPLAY_BOTTOM_PAGER"      => "Y",
        "SET_STATUS_404"            => "N",
        "SHOW_404"                  => "N",
        "MESSAGE_404"               => "",
    ],
    $component,
);

$APPLICATION->ShowViewContent('service-main-section');

global $reviews_service_detail_filter;
if (
    !isset($reviews_service_detail_filter['ID'])
    || empty($reviews_service_detail_filter['ID'])
) {
    $reviews_service_detail_filter['PROPERTY_FROM_TYPE_VALUE'] = 'От пациентов';
}
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "reviews_list_h",
    [
        "COMPONENT_TEMPLATE"        => ".default",
        "IBLOCK_TYPE"               => "content",
        "IBLOCK_ID"                 => "14",
        "NEWS_COUNT"                => "17",
        "SORT_BY1"                  => "ID",
        "SORT_ORDER1"               => "DESC",
        "SORT_BY2"                  => "SORT",
        "SORT_ORDER2"               => "DESC",
        "FILTER_NAME"               => "reviews_service_detail_filter",
        "FIELD_CODE"                => ['DETAIL_TEXT', 'DATE_ACTIVE_FROM'],
        "PROPERTY_CODE"             => ['TITLE'],
        "CHECK_DATES"               => "Y",
        "AJAX_MODE"                 => "N",
        "AJAX_OPTION_JUMP"          => "N",
        "AJAX_OPTION_STYLE"         => "Y",
        "AJAX_OPTION_HISTORY"       => "N",
        "AJAX_OPTION_ADDITIONAL"    => "",
        "CACHE_TYPE"                => "A",
        "CACHE_TIME"                => "36000000",
        "CACHE_FILTER"              => "N",
        "CACHE_GROUPS"              => "N",
        "ACTIVE_DATE_FORMAT"        => "j M Y",
        "SET_TITLE"                 => "N",
        "SET_BROWSER_TITLE"         => "N",
        "SET_META_KEYWORDS"         => "N",
        "SET_META_DESCRIPTION"      => "N",
        "SET_LAST_MODIFIED"         => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN"        => "N",
        "HIDE_LINK_WHEN_NO_DETAIL"  => "N",
        "PARENT_SECTION"            => "",
        "PARENT_SECTION_CODE"       => "",
        "INCLUDE_SUBSECTIONS"       => "N",
        "STRICT_SECTION_CHECK"      => "N",
        "DISPLAY_DATE"              => "Y",
        "DISPLAY_NAME"              => "Y",
        "DISPLAY_PICTURE"           => "Y",
        "DISPLAY_PREVIEW_TEXT"      => "Y",
        "PAGER_TEMPLATE"            => "hemonc_ajax",
        "DISPLAY_TOP_PAGER"         => "N",
        "DISPLAY_BOTTOM_PAGER"      => "Y",
        "SET_STATUS_404"            => "N",
        "SHOW_404"                  => "N",
        "MESSAGE_404"               => "",
    ],
    $component,
);

$APPLICATION->ShowViewContent('service-gallery-section');

global $video_service_detail_filter;

$currentServiceId = $arResult["VARIABLES"]["ELEMENT_ID"];

if (empty($currentServiceId) && !empty($arResult["VARIABLES"]["ELEMENT_CODE"])) {
    if (\Bitrix\Main\Loader::includeModule('iblock')) {
        $element = CIBlockElement::GetList(
            [],
            [
                'IBLOCK_ID' => $arParams["IBLOCK_ID"],
                'CODE' => $arResult["VARIABLES"]["ELEMENT_CODE"],
                'ACTIVE' => 'Y'
            ],
            false,
            ['nTopCount' => 1],
            ['ID']
        )->Fetch();
        $currentServiceId = $element['ID'];
    }
}

$videoIds = [];
if ($currentServiceId && \Bitrix\Main\Loader::includeModule('iblock')) {
    $res = CIBlockElement::GetProperty(
        $arParams["IBLOCK_ID"],
        $currentServiceId,
        [],
        ['CODE' => 'VIDEOS']
    );
    while ($prop = $res->Fetch()) {
        if (!empty($prop['VALUE'])) {
            $videoIds[] = $prop['VALUE'];
        }
    }
}

if (!empty($videoIds)) {
    $video_service_detail_filter = ['ID' => $videoIds];
} else {
    $video_service_detail_filter = ['ID' => 0];
}

$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "videos_list_h",
    [
        "COMPONENT_TEMPLATE"        => ".default",
        "IBLOCK_TYPE"               => "content",
        "IBLOCK_ID"                 => "18",
        "NEWS_COUNT"                => "17",
        "SORT_BY1"                  => "SORT",
        "SORT_ORDER1"               => "ASC",
        "SORT_BY2"                  => "SORT",
        "SORT_ORDER2"               => "ASC",
        "FILTER_NAME"               => "video_service_detail_filter",
        "FIELD_CODE"                => ['PREVIEW_TEXT', 'PREVIEW_PICTURE'],
        "PROPERTY_CODE"             => ['TITLE', 'VIDEO_LINK', 'AUTHOR_DESCRIPTION'],
        "CHECK_DATES"               => "Y",
        "AJAX_MODE"                 => "N",
        "AJAX_OPTION_JUMP"          => "N",
        "AJAX_OPTION_STYLE"         => "Y",
        "AJAX_OPTION_HISTORY"       => "N",
        "AJAX_OPTION_ADDITIONAL"    => "",
        "CACHE_TYPE"                => "N",
        "CACHE_TIME"                => "36000000",
        "CACHE_FILTER"              => "N",
        "CACHE_GROUPS"              => "N",
        "ACTIVE_DATE_FORMAT"        => "j M Y",
        "SET_TITLE"                 => "N",
        "SET_BROWSER_TITLE"         => "N",
        "SET_META_KEYWORDS"         => "N",
        "SET_META_DESCRIPTION"      => "N",
        "SET_LAST_MODIFIED"         => "N",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "ADD_SECTIONS_CHAIN"        => "N",
        "HIDE_LINK_WHEN_NO_DETAIL"  => "N",
        "PARENT_SECTION"            => "",
        "PARENT_SECTION_CODE"       => "",
        "INCLUDE_SUBSECTIONS"       => "N",
        "STRICT_SECTION_CHECK"      => "N",
        "DISPLAY_DATE"              => "Y",
        "DISPLAY_NAME"              => "Y",
        "DISPLAY_PICTURE"           => "Y",
        "DISPLAY_PREVIEW_TEXT"      => "Y",
        "PAGER_TEMPLATE"            => "hemonc_ajax",
        "DISPLAY_TOP_PAGER"         => "N",
        "DISPLAY_BOTTOM_PAGER"      => "Y",
        "SET_STATUS_404"            => "N",
        "SHOW_404"                  => "N",
        "MESSAGE_404"               => "",
    ],
    $component,
);

global $faq_bottom_service_detail_filter;
if (
    !isset($faq_bottom_service_detail_filter['ID'])
    || empty($faq_bottom_service_detail_filter['ID'])
) {
    $APPLICATION->IncludeComponent(
        "bitrix:news.detail",
        "faq_bg",
        [
            "IBLOCK_TYPE"               => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID"                 => $arParams["IBLOCK_ID"],
            "PROPERTY_CODE"             => $arParams["DETAIL_PROPERTY_CODE"],
            "SET_META_DESCRIPTION"      => "N",
            "SET_CANONICAL_URL"         => 'N',
            "SET_BROWSER_TITLE"         => "N",
            "SET_TITLE"                 => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => 'N',
            "ADD_SECTIONS_CHAIN"        => 'N',
            "CACHE_TYPE"                => $arParams["CACHE_TYPE"],
            "CACHE_TIME"                => $arParams["CACHE_TIME"],
            "CACHE_GROUPS"              => $arParams["CACHE_GROUPS"],
            "ELEMENT_ID"                => $arResult["VARIABLES"]["ELEMENT_ID"],
            "ELEMENT_CODE"              => $arResult["VARIABLES"]["ELEMENT_CODE"],
            "SECTION_ID"                => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE"              => $arResult["VARIABLES"]["SECTION_CODE"],
            "IBLOCK_URL"                => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
            "ADD_ELEMENT_CHAIN"         => 'N',
        ],
        $component,
    );
} else {
    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "faq_bg",
        [
            "COMPONENT_TEMPLATE"        => ".default",
            "IBLOCK_TYPE"               => "content",
            "IBLOCK_ID"                 => "24",
            "NEWS_COUNT"                => "17",
            "SORT_BY1"                  => "SORT",
            "SORT_ORDER1"               => "ASC",
            "SORT_BY2"                  => "SORT",
            "SORT_ORDER2"               => "ASC",
            "FILTER_NAME"               => "faq_bottom_service_detail_filter",
            "FIELD_CODE"                => ['PREVIEW_TEXT', 'PREVIEW_PICTURE'],
            "PROPERTY_CODE"             => ['TITLE'],
            "CHECK_DATES"               => "Y",
            "AJAX_MODE"                 => "N",
            "AJAX_OPTION_JUMP"          => "N",
            "AJAX_OPTION_STYLE"         => "Y",
            "AJAX_OPTION_HISTORY"       => "N",
            "AJAX_OPTION_ADDITIONAL"    => "",
            "CACHE_TYPE"                => "N",
            "CACHE_TIME"                => "36000000",
            "CACHE_FILTER"              => "N",
            "CACHE_GROUPS"              => "N",
            "ACTIVE_DATE_FORMAT"        => "j M Y",
            "SET_TITLE"                 => "N",
            "SET_BROWSER_TITLE"         => "N",
            "SET_META_KEYWORDS"         => "N",
            "SET_META_DESCRIPTION"      => "N",
            "SET_LAST_MODIFIED"         => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN"        => "N",
            "HIDE_LINK_WHEN_NO_DETAIL"  => "N",
            "PARENT_SECTION"            => "",
            "PARENT_SECTION_CODE"       => "",
            "INCLUDE_SUBSECTIONS"       => "N",
            "STRICT_SECTION_CHECK"      => "N",
            "DISPLAY_DATE"              => "Y",
            "DISPLAY_NAME"              => "Y",
            "DISPLAY_PICTURE"           => "Y",
            "DISPLAY_PREVIEW_TEXT"      => "Y",
            "PAGER_TEMPLATE"            => "hemonc_ajax",
            "DISPLAY_TOP_PAGER"         => "N",
            "DISPLAY_BOTTOM_PAGER"      => "Y",
            "SET_STATUS_404"            => "N",
            "SHOW_404"                  => "N",
            "MESSAGE_404"               => "",
        ],
        $component,
    );
}

$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    [
        "PATH"           => SITE_TEMPLATE_PATH . "/parts/hemonc2_cta_formBitx24.php",
        "AREA_FILE_SHOW" => "file",
    ],
);

\Bitrix\Main\Loader::includeModule('dev2fun.opengraph');
\Dev2fun\Module\OpenGraph::Show($ElementID, 'element');
