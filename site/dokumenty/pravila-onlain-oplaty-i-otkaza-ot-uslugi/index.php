<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->IncludeComponent(
    "bitrix:news.detail",
    "page_text",
    [
        "ACTIVE_DATE_FORMAT"         => "j F Y",
        "ADD_ELEMENT_CHAIN"          => "N",
        "ADD_SECTIONS_CHAIN"         => "N",
        "AJAX_MODE"                  => "N",
        "AJAX_OPTION_ADDITIONAL"     => "",
        "AJAX_OPTION_HISTORY"        => "N",
        "AJAX_OPTION_JUMP"           => "N",
        "AJAX_OPTION_STYLE"          => "N",
        "BROWSER_TITLE"              => "TITLE",
        "CACHE_GROUPS"               => "N",
        "CACHE_TIME"                 => "36000000",
        "CACHE_TYPE"                 => "A",
        "CHECK_DATES"                => "Y",
        "COMPOSITE_FRAME_MODE"       => "A",
        "COMPOSITE_FRAME_TYPE"       => "AUTO",
        "ELEMENT_CODE"               => "pravila-onlain-oplaty-i-otkaza-ot-uslugi",
        "ELEMENT_ID"                 => "",
        "FIELD_CODE"                 => [],
        "IBLOCK_ID"                  => "7",
        "IBLOCK_TYPE"                => "site",
        "IBLOCK_URL"                 => "",
        "INCLUDE_IBLOCK_INTO_CHAIN"  => "N",
        "MESSAGE_404"                => "",
        "META_DESCRIPTION"           => "DESCRIPTION",
        "META_KEYWORDS"              => "KEYWORDS",
        "PROPERTY_CODE"              => [],
        "SET_BROWSER_TITLE"          => "Y",
        "SET_CANONICAL_URL"          => "Y",
        "SET_LAST_MODIFIED"          => "N",
        "SET_META_DESCRIPTION"       => "Y",
        "SET_META_KEYWORDS"          => "N",
        "SET_STATUS_404"             => "N",
        "SET_TITLE"                  => "Y",
        "SHOW_404"                   => "N",
        "STRICT_SECTION_CHECK"       => "N",
        "USE_PERMISSIONS"            => "N",
        "CSS_CLASS_BODY"             => "service-detail-page",
        "CSS_CLASS_HEADER"           => "default-main-block-header full-width",
        "HEADER_TEXT_CONTAINER"      => "header-next-content",
    ],
);
?>

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
