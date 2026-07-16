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
        "ELEMENT_CODE"              => $arParams['ROOT_ELEMENT_CODE'],
        "ELEMENT_ID"                => "",
        "FIELD_CODE"                => [],
        "IBLOCK_ID"                 => "7",
        "IBLOCK_TYPE"               => "site",
        "IBLOCK_URL"                => "",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "MESSAGE_404"               => "",
        "META_DESCRIPTION"          => "DESCRIPTION",
        "PROPERTY_CODE"             => [],
        "SET_BROWSER_TITLE"         => "Y",
        "SET_CANONICAL_URL"         => "Y",
        "SET_LAST_MODIFIED"         => "N",
        "SET_META_DESCRIPTION"      => "Y",
        "SET_META_KEYWORDS"         => "N",
        "SET_STATUS_404"            => "N",
        "SET_TITLE"                 => "Y",
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
    "banner_main",
    [
        "CHECK_DATES"               => "N",
        "ADD_ELEMENT_CHAIN"         => "N",
        "ADD_SECTIONS_CHAIN"        => "N",
        "AJAX_MODE"                 => "N",
        "CACHE_GROUPS"              => "N",
        "CACHE_TIME"                => "36000000",
        "CACHE_TYPE"                => "A",
        "ELEMENT_CODE"              => $arParams['ROOT_ELEMENT_CODE'],
        "ELEMENT_ID"                => "",
        "IBLOCK_TYPE"               => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID"                 => $arParams["IBLOCK_ID"],
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "SET_BROWSER_TITLE"         => "N",
        "SET_CANONICAL_URL"         => "N",
        "SET_LAST_MODIFIED"         => "N",
        "SET_META_DESCRIPTION"      => "N",
        "SET_META_KEYWORDS"         => "N",
        "SET_STATUS_404"            => "N",
        "SET_TITLE"                 => "N",
        "PROPERTY_CODE"             => $arParams["DETAIL_PROPERTY_CODE"],
        "SHOW_404"                  => "N",
        'SHOW_BANNER_TITLE'         => 'Y',
        'SHOW_BANNER_SUBTITLE'      => 'N',
    ],
    $component,
);

global $service_main_filter;
$service_main_filter['PROPERTY_SHOW_IN_ROOT_VALUE'] = 'Показывать';

$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "services_list",
    [
        "IBLOCK_TYPE"   => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID"     => $arParams["IBLOCK_ID"],
        "NEWS_COUNT"    => $arParams["NEWS_COUNT"],
        "SORT_BY1"      => $arParams["SORT_BY1"],
        "SORT_ORDER1"   => $arParams["SORT_ORDER1"],
        "SORT_BY2"      => $arParams["SORT_BY2"],
        "SORT_ORDER2"   => $arParams["SORT_ORDER2"],
        "FIELD_CODE"    => $arParams["LIST_FIELD_CODE"],
        "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
        "DETAIL_URL"    => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
        "SECTION_URL"   => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
        "IBLOCK_URL"    => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
        // "SET_TITLE"                       => $arParams["SET_TITLE"],
        "SET_TITLE"                       => "N",
        "SET_LAST_MODIFIED"               => $arParams["SET_LAST_MODIFIED"],
        "MESSAGE_404"                     => $arParams["MESSAGE_404"],
        "SET_STATUS_404"                  => $arParams["SET_STATUS_404"],
        "SHOW_404"                        => $arParams["SHOW_404"],
        "FILE_404"                        => $arParams["FILE_404"],
        "INCLUDE_IBLOCK_INTO_CHAIN"       => 'N',
        "ADD_SECTIONS_CHAIN"              => 'N',
        "ADD_ELEMENT_CHAIN"               => 'N',
        "CACHE_TYPE"                      => $arParams["CACHE_TYPE"],
        "CACHE_TIME"                      => $arParams["CACHE_TIME"],
        "CACHE_FILTER"                    => $arParams["CACHE_FILTER"],
        "CACHE_GROUPS"                    => $arParams["CACHE_GROUPS"],
        "DISPLAY_TOP_PAGER"               => $arParams["DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER"            => $arParams["DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE"                     => $arParams["PAGER_TITLE"],
        "PAGER_TEMPLATE"                  => $arParams["PAGER_TEMPLATE"],
        "PAGER_SHOW_ALWAYS"               => $arParams["PAGER_SHOW_ALWAYS"],
        "PAGER_DESC_NUMBERING"            => $arParams["PAGER_DESC_NUMBERING"],
        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
        "PAGER_SHOW_ALL"                  => $arParams["PAGER_SHOW_ALL"],
        "PAGER_BASE_LINK_ENABLE"          => $arParams["PAGER_BASE_LINK_ENABLE"],
        "PAGER_BASE_LINK"                 => $arParams["PAGER_BASE_LINK"],
        "PAGER_PARAMS_NAME"               => $arParams["PAGER_PARAMS_NAME"],
        "DISPLAY_DATE"                    => $arParams["DISPLAY_DATE"],
        "DISPLAY_NAME"                    => "Y",
        "DISPLAY_PICTURE"                 => $arParams["DISPLAY_PICTURE"],
        "DISPLAY_PREVIEW_TEXT"            => 'N',
        "PREVIEW_TRUNCATE_LEN"            => $arParams["PREVIEW_TRUNCATE_LEN"],
        "ACTIVE_DATE_FORMAT"              => $arParams["LIST_ACTIVE_DATE_FORMAT"],
        "USE_PERMISSIONS"                 => $arParams["USE_PERMISSIONS"],
        "GROUP_PERMISSIONS"               => $arParams["GROUP_PERMISSIONS"],
        "FILTER_NAME"                     => "service_main_filter",
        "HIDE_LINK_WHEN_NO_DETAIL"        => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
        "CHECK_DATES"                     => $arParams["CHECK_DATES"],
    ],
    $component,
);

global $video_service_detail_filter;

$currentServiceId = $arResult["VARIABLES"]["ELEMENT_ID"];

if (empty($currentServiceId) && !empty($arResult["VARIABLES"]["ELEMENT_CODE"])) {
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

$video_service_detail_filter = [
    'PROPERTY_VIDEOS_VALUE' => $currentServiceId
];

$video_service_detail_filter = [
    [
        'LOGIC' => 'OR',
        ['PROPERTY_VIDEOS_VALUE' => $currentServiceId],
    ]
];
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
        "PROPERTY_CODE"             => ['TITLE', 'VIDEO_LINK', 'AUTHOR_DESCRIPTION'],        "CHECK_DATES"               => "Y",
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

$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "faq_bg",
    [
        "CHECK_DATES"               => "N",
        "ADD_ELEMENT_CHAIN"         => "N",
        "ADD_SECTIONS_CHAIN"        => "N",
        "AJAX_MODE"                 => "N",
        "CACHE_GROUPS"              => "N",
        "CACHE_TIME"                => "36000000",
        "CACHE_TYPE"                => "A",
        "ELEMENT_CODE"              => $arParams['ROOT_ELEMENT_CODE'],
        "ELEMENT_ID"                => "",
        "IBLOCK_TYPE"               => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID"                 => $arParams["IBLOCK_ID"],
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "SET_BROWSER_TITLE"         => "N",
        "SET_CANONICAL_URL"         => "N",
        "SET_LAST_MODIFIED"         => "N",
        "SET_META_DESCRIPTION"      => "N",
        "SET_META_KEYWORDS"         => "N",
        "SET_STATUS_404"            => "N",
        "SET_TITLE"                 => "N",
        "PROPERTY_CODE"             => $arParams["DETAIL_PROPERTY_CODE"],
        "SHOW_404"                  => "N",
    ],
    $component,
);

$APPLICATION->IncludeComponent(
    "bitrix:main.include",
    "",
    [
        "PATH"           => SITE_TEMPLATE_PATH . "/parts/hemonc2_cta_formBitx24.php",
        "AREA_FILE_SHOW" => "file",
    ],
);
