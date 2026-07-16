<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$APPLICATION->SetPageProperty('canonical', 'https://hemonc.ru/');

$APPLICATION->AddHeadString('<meta name="twitter:card" content="summary_large_image" />');

?>
<article class="main-content">
    <div class="wrapper">
        <?php $APPLICATION->IncludeComponent(
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
                "ELEMENT_CODE"               => "index",
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
                "SET_CANONICAL_URL"          => "N",
                "SET_LAST_MODIFIED"          => "N",
                "SET_META_DESCRIPTION"       => "Y",
                "SET_META_KEYWORDS"          => "N",
                "SET_STATUS_404"             => "N",
                "SET_TITLE"                  => "Y",
                "SHOW_404"                   => "N",
                "STRICT_SECTION_CHECK"       => "N",
                "USE_PERMISSIONS"            => "N",
                // "CSS_CLASS_BODY"             => "",
                // "CSS_CLASS_HEADER"           => "",
                // "HEADER_TEXT_CONTAINER"      => "",
            ],
        );?>
        <div class="grid-row grid-row-root cols-b2 cols-m1">
            <div class="grid-col">
                <?php
                    global $reviews_index_filter;
                    $reviews_index_filter = [
                        'PROPERTY_FROM_TYPE_VALUE' => 'От друзей',
                    ];
                    $APPLICATION->IncludeComponent(
                        "bitrix:news.list",
                        "reviews_index",
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
            </div>
            <div class="grid-col">
                <div class="grid-row grid-row-flex cols-b2 cols-m2">
                    <div class="services-nav-block grid-col">
                        <a href="/services/" class="head">
                            <span class="title">УСЛУГИ</span>
                        </a>
                        <ul>
                            <li>
                                <a style="display: inline-block;" href="/services/consultation/">
                                    <span class="icon">
                                        <i class="svg-icon-serv-consult"></i>
                                        <i class="svg-icon-serv-consult-hover"></i>
                                    </span>
                                    <span>Консультация</span>
                                </a>
                            </li>
                            <li>
                                <a style="display: inline-block;" href="/services/diagnostics/">
                                    <span class="icon">
                                        <i class="svg-icon-serv-diag"></i>
                                        <i class="svg-icon-serv-diag-hover"></i>
                                    </span>
                                    <span>Диагностика</span>
                                </a>
                            </li>
                            <li>
                                <a style="display: inline-block;" href="/services/treatment/">
                                    <span class="icon">
                                        <i class="svg-icon-serv-heal"></i>
                                        <i class="svg-icon-serv-heal-hover"></i>
                                    </span>
                                    <span>Лечение</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="services-nav-block grid-col">
                        <a href="/about-us/" class="head">
                            <span class="title">УЗНАТЬ БОЛЬШЕ</span>
                        </a>
                        <ul>
                            <li>
                                <a href="/about-us/our-doctors/">
                                    <span class="icon">
                                        <i class="svg-icon-serv-doctor"></i>
                                        <i class="svg-icon-serv-doctor-hover"></i>
                                    </span>
                                    <span>Врачи</span>
                                </a>
                            </li>
                            <li>
                                <a href="/about-us/about-the-clinic/">
                                    <span class="icon">
                                        <i class="svg-icon-serv-about"></i>
                                        <i class="svg-icon-serv-about-hover"></i>
                                    </span>
                                    <span>Наши ценности</span>
                                </a>
                            </li>
                            <li class="for-big">
                                <a href="https://t.me/ht_hemonc_bot?start=glavnaya_desktop" onclick="ym(37372215, 'reachGoal', 'bot-main-desktop');">
                                    <span class="icon">
                                        <i class="svg-icon-serv-blog"></i>
                                        <i class="svg-icon-serv-blog-hover"></i>
                                    </span>
                                    <span>Рассчитать стоимость</span>
                                </a>
                            </li>
                            <li class="for-small">
                                <a href="https://t.me/ht_hemonc_bot?start=glavnaya_mob" onclick="ym(37372215, 'reachGoal', 'bot-main-mobile');">
                                    <span class="icon">
                                        <i class="svg-icon-serv-blog"></i>
                                        <i class="svg-icon-serv-blog-hover"></i>
                                    </span>
                                    <span>Рассчитать стоимость</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="info-block">
                    <div class="info-title mb-r6">
                        СТАТЬИ, ВИДЕО И ПОЛЕЗНЫЕ ССЫЛКИ
                    </div>
                    <ul style="list-style: disc; padding: 0 40px 24px;">
                        <li class="info-item mb-r3">
                            <a href="/video/">Лекции и эфиры о диагностике и лечении рака</a>
                        </li>
                        <li class="info-item mb-r3">
                            <a href="/poleznoe/">Руководства и рекомендации для пациентов и их близких</a>
                        </li>
                        <li class="info-item">
                            <a href="/about-us/blog/">Мы в СМИ</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</article>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
