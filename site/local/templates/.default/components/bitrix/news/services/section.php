<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);

$APPLICATION->SetPageProperty('canonical', 'https://' . SITE_SERVER_NAME . $APPLICATION->GetCurPage());

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

if ($arResult["VARIABLES"]['SECTION_CODE_PATH'] == "treatment/chemotherapy") {
    $arResult["VARIABLES"]["ELEMENT_ID"] = 4571;
    $arResult["VARIABLES"]["ELEMENT_CODE"] = "khimioterapiia";

    $ElementID = $APPLICATION->IncludeComponent(
        "bitrix:news.detail",
        "",
        [
            "DISPLAY_DATE"              => $arParams["DISPLAY_DATE"],
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
            "SET_STATUS_404"            => "N",
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
            'STRICT_SECTION_CHECK'      => 'N',
            'nearestTimeWeekAll'        => \Hemonc\Ajax::getSchedule(),
            
        ],
        $component,
    );

    $arSection = \Bitrix\Iblock\SectionTable::getList([
        'filter' => [
            'IBLOCK_ID' => $arParams["IBLOCK_ID"],
            'CODE'      => $arResult['VARIABLES']['SECTION_CODE'],
        ],
        'select' => [
            'ID',
            'IBLOCK_SECTION_ID',
        ],
    ])->fetch();

    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "services_section",
        [
            "IBLOCK_TYPE"                     => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID"                       => $arParams["IBLOCK_ID"],
            "NEWS_COUNT"                      => $arParams["NEWS_COUNT"],
            "SORT_BY1"                        => $arParams["SORT_BY1"],
            "SORT_ORDER1"                     => $arParams["SORT_ORDER1"],
            "SORT_BY2"                        => $arParams["SORT_BY2"],
            "SORT_ORDER2"                     => $arParams["SORT_ORDER2"],
            "FIELD_CODE"                      => $arParams["LIST_FIELD_CODE"],
            "PROPERTY_CODE"                   => $arParams["LIST_PROPERTY_CODE"],
            "DETAIL_URL"                      => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
            "SECTION_URL"                     => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
            "IBLOCK_URL"                      => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
            "SET_BROWSER_TITLE"               => "N",
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
            "FILTER_NAME"                     => $arParams["FILTER_NAME"],
            "HIDE_LINK_WHEN_NO_DETAIL"        => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
            "CHECK_DATES"                     => $arParams["CHECK_DATES"],
            "SET_META_DESCRIPTION"            => "N",
            'PARENT_SECTION'                  => $arSection['IBLOCK_SECTION_ID'],
        ],
        $component,
    );
    ?>

    <section class="service-info-block">
        <div class="wrapper">
            <div class="foot">
                <p style="max-width: 900px;">
                    Мы считаем, что общаться с пациентами так же важно, как поставить диагноз или сделать «карту» лечения.
                    Если у вас остались вопросы, пишите нам на почту <a
                        href="mailto:<?=\Hemonc\Params::p('email')?>"><?=\Hemonc\Params::p('email')?></a>
                    или звоните по телефонам клиники — мы с удовольствием с вами пообщаемся!
                </p>
            </div>
        </div>
    </section>
    
    <script>
        $(document).ready(function() {
            window.setTimeout(function () {
                var htop = 0; 
                var children = $('#right-clmn > p').children();
                for (var idx = 0; idx < children.length; idx++) {
                    htop += $(children[idx]).height();
                }
                var h = $('#right-clmn').height() - htop - 20;
                if (h > 200) {
                    var sc = Math.floor(h / 48);
                    var h2 = sc * 48;
                    $('#blog-list').css('top', (htop + 20) + 'px');
                    $('#blog-list').css('height', h2 + 'px');
                }
            },200);
        });
    </script>

    <?
}
else {
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "services_section",
    [
        "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
        "IBLOCK_ID"   => $arParams["IBLOCK_ID"],
        "NEWS_COUNT"  => $arParams["NEWS_COUNT"],

        "SORT_BY1"    => $arParams["SORT_BY1"],
        "SORT_ORDER1" => $arParams["SORT_ORDER1"],
        "SORT_BY2"    => $arParams["SORT_BY2"],
        "SORT_ORDER2" => $arParams["SORT_ORDER2"],

        "FILTER_NAME"          => $arParams["FILTER_NAME"],
        "FIELD_CODE"           => $arParams["LIST_FIELD_CODE"],
        "PROPERTY_CODE"        => $arParams["LIST_PROPERTY_CODE"],
        "CHECK_DATES"          => $arParams["CHECK_DATES"],
        "STRICT_SECTION_CHECK" => $arParams["STRICT_SECTION_CHECK"],
        "IBLOCK_URL"           => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["news"],
        "SECTION_URL"          => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
        "DETAIL_URL"           => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["detail"],
        "SEARCH_PAGE"          => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["search"],

        "CACHE_TYPE"   => $arParams["CACHE_TYPE"],
        "CACHE_TIME"   => $arParams["CACHE_TIME"],
        "CACHE_FILTER" => $arParams["CACHE_FILTER"],
        "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

        "PREVIEW_TRUNCATE_LEN"      => $arParams["PREVIEW_TRUNCATE_LEN"],
        "ACTIVE_DATE_FORMAT"        => $arParams["LIST_ACTIVE_DATE_FORMAT"],
        "SET_TITLE"                 => "Y",
        "SET_BROWSER_TITLE"         => "Y",
        "SET_META_KEYWORDS"         => "N",
        "SET_META_DESCRIPTION"      => "Y",
        "MESSAGE_404"               => $arParams["MESSAGE_404"],
        "SET_STATUS_404"            => $arParams["SET_STATUS_404"],
        "SHOW_404"                  => $arParams["SHOW_404"],
        "FILE_404"                  => $arParams["FILE_404"],
        "SET_LAST_MODIFIED"         => $arParams["SET_LAST_MODIFIED"],
        "INCLUDE_IBLOCK_INTO_CHAIN" => 'N',
        "ADD_SECTIONS_CHAIN"        => 'Y',
        "ADD_ELEMENT_CHAIN"         => 'N',
        "HIDE_LINK_WHEN_NO_DETAIL"  => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],

        "PARENT_SECTION"      => $arResult["VARIABLES"]["SECTION_ID"],
        "PARENT_SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
        "INCLUDE_SUBSECTIONS" => "Y",

        "DISPLAY_DATE"         => $arParams["DISPLAY_DATE"],
        "DISPLAY_NAME"         => "Y",
        "DISPLAY_PICTURE"      => $arParams["DISPLAY_PICTURE"],
        "DISPLAY_PREVIEW_TEXT" => 'Y',
        "MEDIA_PROPERTY"       => $arParams["MEDIA_PROPERTY"],
        "SLIDER_PROPERTY"      => $arParams["SLIDER_PROPERTY"],

        "PAGER_TEMPLATE"                  => $arParams["PAGER_TEMPLATE"],
        "DISPLAY_TOP_PAGER"               => $arParams["DISPLAY_TOP_PAGER"],
        "DISPLAY_BOTTOM_PAGER"            => $arParams["DISPLAY_BOTTOM_PAGER"],
        "PAGER_TITLE"                     => $arParams["PAGER_TITLE"],
        "PAGER_SHOW_ALWAYS"               => $arParams["PAGER_SHOW_ALWAYS"],
        "PAGER_DESC_NUMBERING"            => $arParams["PAGER_DESC_NUMBERING"],
        "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
        "PAGER_SHOW_ALL"                  => $arParams["PAGER_SHOW_ALL"],
        "PAGER_BASE_LINK_ENABLE"          => $arParams["PAGER_BASE_LINK_ENABLE"],
        "PAGER_BASE_LINK"                 => $arParams["PAGER_BASE_LINK"],
        "PAGER_PARAMS_NAME"               => $arParams["PAGER_PARAMS_NAME"],

        "USE_RATING"        => $arParams["USE_RATING"],
        "DISPLAY_AS_RATING" => $arParams["DISPLAY_AS_RATING"],
        "MAX_VOTE"          => $arParams["MAX_VOTE"],
        "VOTE_NAMES"        => $arParams["VOTE_NAMES"],

        "USE_SHARE"               => $arParams["LIST_USE_SHARE"],
        "SHARE_HIDE"              => $arParams["SHARE_HIDE"],
        "SHARE_TEMPLATE"          => $arParams["SHARE_TEMPLATE"],
        "SHARE_HANDLERS"          => $arParams["SHARE_HANDLERS"],
        "SHARE_SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
        "SHARE_SHORTEN_URL_KEY"   => $arParams["SHARE_SHORTEN_URL_KEY"],

        "TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
    ],
    $component,
);
?>

<section class="reference-block title-block">
    <div class="wrapper">
        <div class="gray-block">
            <h2 class="title">Остались вопросы?</h2>
            <div class="main-block-load-reference-contacts main-block-load">
                <div class="floatingBarsGBG"></div>
                <div class="floatingBarsG">
                    <div class="blockG rotateG_01"></div>
                    <div class="blockG rotateG_02"></div>
                    <div class="blockG rotateG_03"></div>
                    <div class="blockG rotateG_04"></div>
                    <div class="blockG rotateG_05"></div>
                    <div class="blockG rotateG_06"></div>
                    <div class="blockG rotateG_07"></div>
                    <div class="blockG rotateG_08"></div>
                </div>
                <p>
                    Мы считаем, что общаться с пациентами так же важно, как поставить диагноз или сделать «карту» лечения. 
                    Если у вас есть вопросы, оставьте свой номер телефона, и мы свяжемся с вами в течение часа.
                </p>
                <div>
                <?php $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    [
                        "PATH"           => SITE_TEMPLATE_PATH . "/parts/header_callbackForm.php",
                        "AREA_FILE_SHOW" => "file",
                    ],
                )?>
                </div>
            </div>
        </div>
    </div>
</section>
<?
}
?>