<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->IncludeComponent(
    "bitrix:news",
    "zabolevaniya",
    [
        "ADD_ELEMENT_CHAIN"               => "N",
        "ADD_SECTIONS_CHAIN"              => "N",
        "AJAX_MODE"                       => "N",
        "AJAX_OPTION_ADDITIONAL"          => "",
        "AJAX_OPTION_HISTORY"             => "Y",
        "AJAX_OPTION_JUMP"                => "N",
        "AJAX_OPTION_STYLE"               => "Y",
        "CACHE_FILTER"                    => "N",
        "CACHE_GROUPS"                    => "N",
        "CACHE_TIME"                      => "36000000",
        "CACHE_TYPE"                      => "A",
        "CATEGORY_CODE"                   => "CATEGORY",
        "CATEGORY_IBLOCK"                 => [],
        "CATEGORY_ITEMS_COUNT"            => "500",
        "CHECK_DATES"                     => "Y",
        "COMPOSITE_FRAME_MODE"            => "A",
        "COMPOSITE_FRAME_TYPE"            => "AUTO",
        "DETAIL_ACTIVE_DATE_FORMAT"       => "j F Y",
        "DETAIL_DISPLAY_BOTTOM_PAGER"     => "Y",
        "DETAIL_DISPLAY_TOP_PAGER"        => "N",
        "DISPLAY_BOTTOM_PAGER"            => "Y",
        "DISPLAY_TOP_PAGER"               => "N",
        "PAGER_BASE_LINK"                 => "",
        "PAGER_BASE_LINK_ENABLE"          => "Y",
        "PAGER_DESC_NUMBERING"            => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_PARAMS_NAME"               => "arrPager",
        "PAGER_SHOW_ALL"                  => "N",
        "PAGER_SHOW_ALWAYS"               => "Y",
        "PAGER_TEMPLATE"                  => "hemonc_pager",
        "PAGER_TITLE"                     => "Новости",
        "DETAIL_FIELD_CODE"               => ['PREVIEW_PICTURE'],
        "DETAIL_PROPERTY_CODE"            => ['TITLE'],
        "DETAIL_SET_CANONICAL_URL"        => "Y",
        "FILTER_FIELD_CODE"               => [],
        "FILTER_NAME"                     => "",
        "FILTER_PROPERTY_CODE"            => [],
        "IBLOCK_ID"                       => "22",
        "IBLOCK_TYPE"                     => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN"       => "N",
        "LIST_ACTIVE_DATE_FORMAT"         => "j F Y",
        "LIST_FIELD_CODE"                 => ['DETAIL_TEXT', 'PREVIEW_TEXT'],
        "LIST_PROPERTY_CODE"              => ['TITLE'],
        "MESSAGE_404"                     => "",
        "NEWS_COUNT"                      => "500",
        "SEF_FOLDER"                      => "/zabolevaniya/",
        "SEF_MODE"                        => "Y",
        "SEF_URL_TEMPLATES"               => ["detail" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/", "section" => "#SECTION_CODE_PATH#/"],
        "SET_STATUS_404"                  => "Y",
        "SET_TITLE"                       => "Y",
        "SHOW_404"                        => "Y",
        "SORT_BY1"                        => "ACTIVE_FROM",
        "SORT_BY2"                        => "SORT",
        "SORT_ORDER1"                     => "DESC",
        "SORT_ORDER2"                     => "ASC",
        "STRICT_SECTION_CHECK"            => "Y",
        // "META_DESCRIPTION"                => "-",
    ],
);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
