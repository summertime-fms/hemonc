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
        "ELEMENT_CODE"               => "contacts",
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
        "CSS_CLASS_BODY"             => "contacts-page",
        "CSS_CLASS_HEADER"           => "default-main-block-header",
        "HEADER_TEXT_CONTAINER"      => "header-content",
    ],
);
?>

<style>
    .map-wrapper {
        position: relative;
        width: 100%;
        height: 100%
    }

    #map {
        width: 100%;
        height: 100%;
    }
    .map-body{
        height: 100%;
        overflow: hidden;
    }
    .geo-btn {
        white-space: nowrap;
        cursor: pointer;
        z-index: 3;
        padding: 1rem 1.25rem;
        font-size: 1rem;
    }
    .contacts-main-maps .title{
        padding-top: 1rem;
    }
    .geo-links {
        padding: .5rem 0;
        position: absolute;
        background-color: #FFF;
        top: 5.375rem;
        left: 1.25rem;
        display: none;
        flex-direction: column;
        z-index: 3;
        border-radius: .65rem;
    }

    .geo-links a {
        white-space: nowrap;
        padding: 1rem 1.25rem;
        text-decoration: none;
        color: black;
        font-weight: 500;
        transition: .3s;
    }
    .geo-links a:hover {
        text-decoration: underline;
    }
    .panel-menu{
        z-index: 3;
        height: fit-content;
        width: fit-content;
        position: absolute;
        top: 0;
        left: 0;
        transition: .3s;
        opacity: 1;
    }
    /*.panel-menu.panel-visible{*/
    /*    left: 0;*/
    /*    opacity: 1;*/
    /*}*/
    .panel-menu__control{
        position: absolute;
        top: 1.25rem;
        left: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .close-zoom{
        padding: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #FFF;
        border-radius: 50%;
        cursor: pointer;
        width: 2rem;
        height: 2rem;
    }
    .close-zoom svg{
        width: 1rem;
        height: 1rem;
    }
    .contacts-main-container{
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }
    .contacts-page__info-block
    .contacts-main-block .contacts-main-container{
        flex-direction: column !important;
    }
    @media screen and (max-width: 1200px) {
        .close-zoom{
            top: 17px;
        }
        .panel-menu{
            width: 28%;
        }
    }
    @media screen and (max-width: 768px) {
        .panel-menu__control{
            top: .75rem;
            left: .75rem;
        }
        .geo-btn{
            max-width: max-content!important;
            padding: .75rem 1rem;
            font-size: .75rem;
        }
        .geo-links{
            top: 4rem;
        }
        .geo-links a{
            padding: 1rem .5rem;
        }
        .close-zoom{
            top: 24px;
        }
        .panel-menu{
            width: 85%;
        }
        .map-wrapper {
            position: relative;
            width: 100%;
            height: 25rem
        }
    }

    .contacts-page__body{
        width: 100%;
        display: flex;
        gap: 1rem;
    }
    .contacts-main-container{
        flex-direction: column;
    }
    .contacts-main-container > *:first-child{
        width: 100%;
        margin-right: 0;
    }
    .contacts-page__content{
        display: flex;
        gap: 1.5rem;
        width: 100%;
        margin-bottom: 2rem;
    }
    .contacts-page__main-info{
        width: 33%;
    }
    .contacts-page__map-block{
        flex: 1;
        max-height: calc(100vh - 9.125rem);
    }

    @media screen and (max-width: 1200px) {
        .contacts-page__content{
            flex-direction: column;
            gap: 1rem;
        }
        .contacts-page__main-info{
            width: 100%;
        }
        .contacts-page__map-block{
            max-height: 26.25rem;
            height: 26.25rem;
            width: 100%;
            flex: unset;
        }
    }
</style>

<div class="contacts-main-block">
    <div class="wrapper">
        <div class="contacts-main-container">
            <section class="contacts-main-address title-block bgdefault">
                <div class="contacts-page__body">
                    <div class="contacts-page__content">
                        <div class="contacts-page__main-info">
                            <h2 class="title">Данные</h2>
                            <div class="row">
                                <?=\Hemonc\Params::p('contacts-main-address')?>
                            </div>
                        </div>
                        <div class="contacts-page__map-block">
                            <link rel="stylesheet" href="/local/templates/hemonc/css/custom.css">

                            <div class="map-body">
                                <div class="map-wrapper">
                                    <div id="map"></div>
                                    <div class="panel-menu">
                                        <div class="panel-menu__control">
                                            <button class="geo-btn btn" id="geo-btn">Построить маршрут до клиники</button>
                                            <!-- <span class="close-zoom">
                                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.73088 11.0284L0 1.29754L1.29754 0L9.73088 8.43333L18.1642 0L19.4618 1.29754L9.73088 11.0284Z" fill="#282828"/>
                                                    <path d="M9.73088 8.9999L0 18.7308L1.29754 20.0283L9.73088 11.595L18.1642 20.0283L19.4618 18.7308L9.73088 8.9999Z" fill="#282828"/>
                                                    </svg>
                                            </span> -->
                                        </div>
                                        <div class="geo-links" id="geo-links">
                                            <a href="https://yandex.ru/maps/-/CLGcVMMN" target="_blank" id="open-yandex">Открыть в Яндекс картах</a>
                                            <a href="https://go.2gis.com/C5yYD" target="_blank" id="open-2gis">Открыть в 2ГИС</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            <?
                if ($USER->IsAuthorized()):?>
                    <section class="contacts-main-maps title-block">
                        <h2 class="title">Как добраться</h2>
                        <!-- <div class="row"> -->
                            <?php $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "PATH"           => SITE_TEMPLATE_PATH . "/parts/contacts_maps.php",
                                    "AREA_FILE_SHOW" => "file",
                                ],
                            )?>
                        <!-- </div> -->
                    </section>
            <?else:?>
            <section class="contacts-main-maps title-block bgdefault">
                <h2 class="title">Как добраться</h2>
                <div class="row">
                    <?php $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        [
                            "PATH"           => SITE_TEMPLATE_PATH . "/parts/contacts_maps.php",
                            "AREA_FILE_SHOW" => "file",
                        ],
                )?>
                </div>
            </section>
            <? endif?>

            <?php $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                [
                    "PATH"           => SITE_TEMPLATE_PATH . "/parts/header_callbackForm.php",
                    "AREA_FILE_SHOW" => "file",
                ],
            ); ?>
        </div>
    </div>
</div>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
