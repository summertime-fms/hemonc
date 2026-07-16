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
        "ELEMENT_CODE"              => "our-doctors",
        "ELEMENT_ID"                => "",
        "FIELD_CODE"                => [],
        "IBLOCK_ID"                 => "7",
        "IBLOCK_TYPE"               => "site",
        "IBLOCK_URL"                => "",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "MESSAGE_404"               => "",
        "META_DESCRIPTION"          => "DESCRIPTION",
        "META_KEYWORDS"             => "KEYWORDS",
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
        "CSS_CLASS_BODY"            => "blog-page",
        "CSS_CLASS_HEADER"          => "default-main-block-header",
        "HEADER_TEXT_CONTAINER"     => "header-content",
    ],
);

$ElementID = $APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "",
    [
        "DISPLAY_DATE"         => $arParams["DISPLAY_DATE"],
        "DISPLAY_NAME"         => $arParams["DISPLAY_NAME"],
        "DISPLAY_PICTURE"      => $arParams["DISPLAY_PICTURE"],
        "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
        "IBLOCK_TYPE"          => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID"            => $arParams["IBLOCK_ID"],
        "FIELD_CODE"           => $arParams["DETAIL_FIELD_CODE"],
        "PROPERTY_CODE"        => $arParams["DETAIL_PROPERTY_CODE"],
        "DETAIL_URL"           => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
        "SECTION_URL"          => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
        "META_DESCRIPTION"     => $arParams["META_DESCRIPTION"],
        "SET_CANONICAL_URL"    => 'Y',
        "SET_LAST_MODIFIED"    => $arParams["SET_LAST_MODIFIED"],
        // "SET_TITLE"                 => "N",
        // "SET_BROWSER_TITLE"         => "Y",
        "MESSAGE_404"               => $arParams["MESSAGE_404"],
        "SET_STATUS_404"            => $arParams["SET_STATUS_404"],
        "SHOW_404"                  => $arParams["SHOW_404"],
        "FILE_404"                  => $arParams["FILE_404"],
        "INCLUDE_IBLOCK_INTO_CHAIN" => 'N',
        "ADD_SECTIONS_CHAIN"        => 'N',
        "ACTIVE_DATE_FORMAT"        => $arParams["DETAIL_ACTIVE_DATE_FORMAT"],
        "CACHE_TYPE"                => 'A',
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
        "ADD_ELEMENT_CHAIN"         => 'N',
        'STRICT_SECTION_CHECK'      => $arParams['STRICT_SECTION_CHECK'],
        'nearestTimeWeekAll'        => \Hemonc\Ajax::getSchedule(),
    ],
    $component,
);

global $arDocServicesFilter;
$arDocServicesFilter = [
    'ACTIVE'           => 'Y',
    'PROPERTY_DOCTORS' => $ElementID,
];
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "services_doctor_list",
    [
        "COMPONENT_TEMPLATE"        => ".default",
        "IBLOCK_TYPE"               => "content",
        "IBLOCK_ID"                 => "20",
        "NEWS_COUNT"                => "150",
        "SORT_BY1"                  => "ACTIVE_FROM",
        "SORT_ORDER1"               => "DESC",
        "SORT_BY2"                  => "SORT",
        "SORT_ORDER2"               => "ASC",
        "FILTER_NAME"               => "arDocServicesFilter",
        "FIELD_CODE"                => ['DETAIL_TEXT'],
        "PROPERTY_CODE"             => ['FIRST_NAME'],
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
        "PAGER_TEMPLATE"            => ".default",
        "DISPLAY_TOP_PAGER"         => "N",
        "DISPLAY_BOTTOM_PAGER"      => "N",
        "SET_STATUS_404"            => "N",
        "SHOW_404"                  => "N",
        "MESSAGE_404"               => "",
    ],
    false,
);
global $arDoctorReviewsFilter;
$arDoctorReviewsFilter = [
    'ACTIVE'           => 'Y',
    'PROPERTY_DOCTORS' => $ElementID,
];
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "doctor_reviews_slider",
    [
        "IBLOCK_TYPE"               => "site",
        "IBLOCK_ID"                 => "14",
        "NEWS_COUNT"                => "50",
        "SORT_BY1"                  => "ACTIVE_FROM",
        "SORT_ORDER1"               => "DESC",
        "SORT_BY2"                  => "SORT",
        "SORT_ORDER2"               => "ASC",
        "FILTER_NAME"               => "arDoctorReviewsFilter",
        "FIELD_CODE"                => ["NAME", "PREVIEW_TEXT", "DETAIL_TEXT", "PREVIEW_PICTURE"],
        "PROPERTY_CODE"             => ["TITLE", "DOCTORS"],
        "CHECK_DATES"               => "Y",
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
        "INCLUDE_SUBSECTIONS"       => "Y",
        "STRICT_SECTION_CHECK"      => "N",
        "DISPLAY_DATE"              => "N",
        "DISPLAY_NAME"              => "Y",
        "DISPLAY_PICTURE"           => "Y",
        "DISPLAY_PREVIEW_TEXT"      => "Y",
        "DISPLAY_TOP_PAGER"         => "N",
        "DISPLAY_BOTTOM_PAGER"      => "N",
        "SET_STATUS_404"            => "N",
        "SHOW_404"                  => "N",
        "MESSAGE_404"               => "",
    ],
    false,
);

\Bitrix\Main\Page\Asset::getInstance()->addJs("https://prodoctorov.ru/static/js/widget_app.js?v10");

\Bitrix\Main\Loader::includeModule('dev2fun.opengraph');
\Dev2fun\Module\OpenGraph::Show($ElementID,'element');
?>
<style>
    .doctor-services-price-item .service-head-link .service-icon-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .doctor-services-price-item .service-head-link .service-icon {
        width: 40px;
        height: 40px;
        display: block;
        color: inherit;
        fill: currentColor;
    }

    .doctor-services-price-item .service-head-link .service-icon-wrap:last-child {
        display: none;
    }

    .doctor-services-price-item .service-head-link:hover .service-icon-wrap:first-child {
        display: none;
    }

    .doctor-services-price-item .service-head-link:hover .service-icon-wrap:last-child {
        display: inline-flex;
    }
</style>
