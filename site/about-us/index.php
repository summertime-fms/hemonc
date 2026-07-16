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
        "ELEMENT_CODE"               => "about-us",
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
        "CSS_CLASS_BODY"             => "about-page",
        "CSS_CLASS_HEADER"           => "default-main-block-header full-width",
        "HEADER_TEXT_CONTAINER"      => "header-content",
    ],
);
?>

<div class="about-rows">
    <div class="wrapper">
        <div class="about-rows-container">
            <section class="about-rows-doctor bgdefault title-link-block">
                <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "doctors_list",
                        [
                            "COMPONENT_TEMPLATE"        => ".default",
                            "IBLOCK_TYPE"               => "content",
                            "IBLOCK_ID"                 => "15",
                            "NEWS_COUNT"                => "15",
                            "SORT_BY1"                  => "ACTIVE_FROM",
                            "SORT_ORDER1"               => "DESC",
                            "SORT_BY2"                  => "SORT",
                            "SORT_ORDER2"               => "ASC",
                            "FILTER_NAME"               => "",
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
                    );?>
            </section>
            <section class="about-rows-blog bgdefault title-link-block">
                <?php
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "blog_list",
                        [
                            "COMPONENT_TEMPLATE"        => ".default",
                            "IBLOCK_TYPE"               => "content",
                            "IBLOCK_ID"                 => "16",
                            "NEWS_COUNT"                => "11",
                            "SORT_BY1"                  => "ACTIVE_FROM",
                            "SORT_ORDER1"               => "DESC",
                            "SORT_BY2"                  => "SORT",
                            "SORT_ORDER2"               => "ASC",
                            "FILTER_NAME"               => "",
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
                    );?>
            </section>
            <section class="about-rows-feedbacks bgdefault title-link-block">
                <?php
                    global $reviews_index_filter;
                    $reviews_index_filter = [
                        'PROPERTY_FROM_TYPE_VALUE' => 'От друзей',
                    ];
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "reviews_list1",
                        [
                            "COMPONENT_TEMPLATE"        => ".default",
                            "IBLOCK_TYPE"               => "content",
                            "IBLOCK_ID"                 => "14",
                            "NEWS_COUNT"                => "6",
                            "SORT_BY1"                  => "ACTIVE_FROM",
                            "SORT_ORDER1"               => "DESC",
                            "SORT_BY2"                  => "SORT",
                            "SORT_ORDER2"               => "ASC",
                            "FILTER_NAME"               => "reviews_index_filter",
                            "FIELD_CODE"                => ['DETAIL_TEXT'],
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
                            "PAGER_TEMPLATE"            => ".default",
                            "DISPLAY_TOP_PAGER"         => "N",
                            "DISPLAY_BOTTOM_PAGER"      => "N",
                            "SET_STATUS_404"            => "N",
                            "SHOW_404"                  => "N",
                            "MESSAGE_404"               => "",
                        ],
                        false,
                    );?>
            </section>
            <section class="about-rows-about bgdefault text-link-block">
                <div class="text-link-block-head">
                    <div class="t-h2">О КЛИНИКЕ</div>
                    <a href="/about-us/about-the-clinic/" title="О клинике">читать</a>
                </div>
                <div class="text-link-block-content">
                    <p>Наши принципы, ценности и команда.</p>
                </div>
            </section>
            <section class="about-rows-about bgdefault text-link-block">
                <div class="text-link-block-head">
                    <div class="t-h2">СПРАВОЧНИК</div>
                    <a href="/about-us/publications/" title="Справочник">читать</a>
                </div>
                <div class="text-link-block-content">
                    <p>Рассказываем о раке.</p>
                </div>
            </section>
        </div>
    </div>
</div>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
