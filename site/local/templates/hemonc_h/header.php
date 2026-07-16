<?php

/*
* AlexBazowsky @github
* for Headache since aug 2024
*/

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit();
}
global $APPLICATION, $doctorId;
$requestUri = $_SERVER['REQUEST_URI'];
$isApplyPage = (strpos($requestUri, '/apply/') === 0 || strpos($requestUri, '/apply.php') !== false);

if (!$isApplyPage && isset($_GET['pacient_id']) && !empty($_GET['pacient_id'])) {
    $pacientId = (int)$_GET['pacient_id'];

    $getParams = $_GET;
    unset($getParams['pacient_id']);

    if (empty($getParams)) {
        LocalRedirect('/apply/?pacient_id=' . $pacientId);
        exit();
    }
}

$doctorId = 0;

$page_url = $APPLICATION->GetCurPage();

if (preg_match('#^/about-us/our-doctors/([^/]+)/$#', $page_url, $matches)) {
    $doctorCode = $matches[1];

    if (\Bitrix\Main\Loader::includeModule('iblock')) {
        $res = CIBlockElement::GetList(
            [],
            [
                'IBLOCK_ID' => 15,
                '=CODE' => $doctorCode,
                '=ACTIVE' => 'Y',
            ],
            false,
            false,
            ['ID', 'NAME', 'CODE']
        );

        if ($doctor = $res->GetNext()) {
            $doctorId = (int)$doctor['ID'];
        }
    }
}

$LastModified_unix = 1294844676;
$LastModified = gmdate('D, d M Y H:i:s', $LastModified_unix) . ' GMT';

$IfModifiedSince = false;


if (isset($_ENV['HTTP_IF_MODIFIED_SINCE'])) {
    $IfModifiedSince = strtotime($_ENV['HTTP_IF_MODIFIED_SINCE']);
}
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
    $IfModifiedSince = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
}


if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
    exit;
}


header('Last-Modified: ' . $LastModified);

$page_url = $APPLICATION->GetCurPage();
$is_index = ($page_url == "/" || $page_url == "/index.php");
if (!\Bitrix\Main\Loader::includeModule('iblock')) {
    exit('!iblock');
}
?>
<!doctype html>
<html lang="ru">

    <head itemscope itemtype="http://schema.org/WPHeader">
        <?php $APPLICATION->ShowHead();
        ?>

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="format-detection" content="telephone=no">
        <meta name="copyright" lang="ru" content="Клиника доктора Ласкова">
        <meta name="author" content="">

        <title itemprop="headline"><?php $APPLICATION->ShowTitle()?></title>

        <meta name="facebook-domain-verification" content="vbgom8ltvizpvt0vb9u613t8t5xn3n">
        <meta name="mailru-verification" content="3932c95ba23f19b2">
        <!--<meta name="yandex-verification" content="805feffd3a6b717a">-->


        <meta property="og:image" content="/favicon.ico">
        <link rel="shortcut icon" href="/favicon.ico">

        <!-- <link rel="preconnect" href="https://i.ytimg.com"> -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <!-- <link rel="preconnect" href="https://www.youtube.com"> -->
        <link rel="preconnect" href="https://mod.calltouch.ru">

        <?php
        \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/bootstrap-grid.css");
        \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/fonts.css");
        \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/site-f.css");
        \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/doctorsPopup.css");
        \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/header.css");
        // \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/new_page.css");


        // \Bitrix\Main\Page\Asset::getInstance()->addJs("https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js");

        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.min.js");
        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/slick.min.js");
        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.datetimepicker.full.js");
        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/masonry.pkgd.min.js");
        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/vendor/jquery.maskedinput.min.js");

        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/app.js");
        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/ytVideos.js");
        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/calendar.js");
        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/cookiesInfo.js");
        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/doctorsPopup.js");
        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/forms.js");
        \Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/callTouchEvents.js");

        // Новое расписание: подключается только при флаге / cookie / на /schedule-v2/
        // Старые doctorsPopup.js и calendar.js остаются — v2 перехватывает entry-функции поверх них.
        if (function_exists('hemonc_register_schedule_v2_assets')) {
            hemonc_register_schedule_v2_assets();
        }
        ?>
    </head>

    <body
        class="<?=(\CSite::InDir(SITE_DIR . 'index.php')) ? 'main-page ' : $APPLICATION->ShowViewContent('body-class')?>">
        <div style="display:none;" itemscope itemtype="http://schema.org/Organization">
            <meta itemprop="name" content="Клиника доктора Ласкова">
            <link itemprop="url" href="https://hemonc.ru/">
            <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                <meta itemprop="postalCode" content="117556">
                <meta itemprop="addressCountry" content="RU">
                <meta itemprop="addressLocality" content="Москва">
                <meta itemprop="streetAddress" content="<?=\Hemonc\Params::p('header_address')?>1">
            </div>
            <meta itemprop="telephone" content="<?=\Hemonc\Params::p('phone')?>">
            <meta itemprop="email" content="mailto:<?=\Hemonc\Params::p('email')?>">
        </div>

        <div class="cookiesInfo">
            <div class="wrapper">
                <div class="row-f">
                    <div class="cookiesInfo-text">
                        На этом вебсайте собираются файлы cookies – они нужны, чтобы сайт работал лучше.
                        Идентифицировать пользователя по ним нельзя. Продолжая использовать сайт, вы даете согласие на обработку cookies.
                    </div>
                    <div class="col-xs-12 col-sm-3 text-center buttonContainerMobile">
                        <button onclick="closeCookiesInfo()" class="btn_cookies">Понятно</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="page-wrap">

            <?php $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                [
                    // "PATH"           => SITE_TEMPLATE_PATH . "/parts/header_relocate.php",
                    "AREA_FILE_SHOW" => "file",
                ],
            )?>
            <?
            $APPLICATION->ShowPanel();
            ?>
            <header class="header">
                <div class="header__upper">
                    <div class="center-wrap">
                        <div class="header__row">
                            <a href="<?=\Hemonc\Params::p('header_address_link')?>" target="_blank" rel="noopener nofollow" class="header__addy"><?=\Hemonc\Params::p('header_address')?></a>
                            <div class="header__time-row">
                                <?=\Hemonc\Params::p('header_raspisanie_ontop')?>
                            </div>
                            <div class="header__socials">
                                <a href="mailto:<?=\Hemonc\Params::p('email')?>" class="header__mail"><?=\Hemonc\Params::p('email')?></a>
                                <a href="<?=\Hemonc\Params::p('tg_link')?>" class="header__icon --tg"></a>
                                <a href="<?=\Hemonc\Params::p('vk_link')?>" class="header__icon --vk"></a>
<!--                                <a href="--><?php //=\Hemonc\Params::p('max_link')?><!--" class="header__icon --max"></a>-->
                                <a href="<?=\Hemonc\Params::p('yt_link')?>" class="header__icon --yt"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header__bottom">
                    <div class="center-wrap">
                        <div class="header__row">
                            <div class="header__left">
                                <div class="header__desc-burger"></div>
                                <a href="/" class="header__logo">
                                    <span>— </span>
                                    Клиника доктора Ласкова<span>.</span>
                                </a>
                            </div>
                            <div class="header__info">
                                <a href="tel:<?=preg_replace('/[\(\)\s-]/', '', \Hemonc\Params::p('phone'))?>" class="header__phone"><?=\Hemonc\Params::p('phone')?></a>
                                <a href="#" class="header__btn btn --trans" onclick="ShowCallBackPopup()">Обратный звонок</a>
                                <?
                                if (isset($doctorId) && $doctorId > 0) {
                                    ?>
                                    <button class="header__btn btn"
                                            data-id="<?=$doctorId?>"
                                            onclick="ShowPersonalDoctorPopup(<?=$doctorId?>);">

                                        Запись на приём
                                    </button>
                                    <?php
                                } else {
                                    ?>
                                    <a href="#" class="header__btn btn" onclick="SelectDoctorPopup()">Запись на приём</a>
                                    <?php
                                }
                                ?>
                                <a href="/search" class="header__search"></a>
                            </div>
                            <div class="header__mob">
                                <a href="/search" class="header__search"></a>
                                <a href="#" class="header__burger"></a>
                            </div>
                        </div>
                    </div>
                </div>
               <div class="header__submenu">
                    <div class="center-wrap">
                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "header_v2_desktop",
                            [
                                "ROOT_MENU_TYPE"        => "header_desktop",
                                "CHILD_MENU_TYPE"       => "header_desktop_sub",
                                "MAX_LEVEL"             => "4",
                                "USE_EXT"               => "N",
                                "MENU_CACHE_TYPE"       => "A",
                                "MENU_CACHE_TIME"       => "3600",
                                "MENU_CACHE_USE_GROUPS" => "N",
                                "MENU_CACHE_GET_VARS"   => [
                                ],
                                "COMPONENT_TEMPLATE" => "header_v2_desktop",
                                "DELAY"              => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                            ],
                            false,
                        );?>
                    </div>
                </div>
            </header>

            <div class="header__mobile">
                <div class="center-wrap">
                    <div class="header__mobile-wrap">
                        <div class="header__info">
                            <?
                            if (isset($doctorId) && $doctorId > 0) {
                                ?>
                                <button class="show-modal-order-reference-date-modal btn header__btn"
                                        data-id="<?=$doctorId?>"
                                        onclick="ShowPersonalDoctorPopup(<?=$doctorId?>);">

                                    Запись на приём
                                </button>
                                <?php
                            } else {
                                ?>
                                <a href="#" class="header__btn btn" onclick="SelectDoctorPopup()">Запись на приём</a>
                                <?php
                            }
                            ?>
                        </div>

                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "header_v2_mobile",
                            [
                                "ROOT_MENU_TYPE"        => "header_mobile",
                                "CHILD_MENU_TYPE"       => "header_mobile_sub",
                                "MAX_LEVEL"             => "4",
                                "USE_EXT"               => "N",
                                "MENU_CACHE_TYPE"       => "A",
                                "MENU_CACHE_TIME"       => "3600",
                                "MENU_CACHE_USE_GROUPS" => "N",
                                "MENU_CACHE_GET_VARS"   => [
                                ],
                                "COMPONENT_TEMPLATE" => "header_v2_mobile",
                                "DELAY"              => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                            ],
                            false,
                        );?>

                        <div class="header__info">
                            <a href="#" class="header__btn btn --trans" onclick="ShowCallBackPopup()">Позвоните мне</a>
                        </div>

                        <div class="footer__info-links">
                            <a href="tel:<?=preg_replace('/[\(\)\s-]/', '', \Hemonc\Params::p('phone'))?>" class="header__phone"><?=\Hemonc\Params::p('phone')?></a>
                            <a href="<?=\Hemonc\Params::p('header_address_link')?>" target="_blank" rel="noopener nofollow" class="header__addy"><?=\Hemonc\Params::p('address')?></a>
                            <a href="mailto:<?=\Hemonc\Params::p('email')?>" class="header__mail"><?=\Hemonc\Params::p('email')?></a>

                            <div class="footer__contacts">
                                <a href="<?=\Hemonc\Params::p('tg_link')?>" class="header__icon --tg"></a>
                                <a href="<?=\Hemonc\Params::p('yt_link')?>" class="header__icon --yt"></a>
                                <a href="<?=\Hemonc\Params::p('vk_link')?>" class="header__icon --vk"></a>
                            </div>
                        </div>

                        <form action="/search" class="header__mobile-search">
                            <input type="text" name="q"  placeholder="Поиск">
                        </form>
                    </div>
                </div>
            </div>

            <main>
            <?php
            if (!\CSite::InDir(SITE_DIR . 'index.php')) { ?>
                <article class="default-main-block">
                    <div class="wrapper">
                        <header class="<?=$APPLICATION->ShowViewContent('header-class')?>">
                            <?php if (!isset($isLanding) || !$isLanding): ?>

                            <h1><?=$APPLICATION->ShowTitle(false)?></h1>
                            <?php endif; ?>

                            <?php $APPLICATION->IncludeComponent(
                            "bitrix:breadcrumb",
                            "hemonc1",
                            [],
                            false,
                        ); ?>
                            <?php $APPLICATION->ShowViewContent('header-content');?>
                        </header>
                        <?php $APPLICATION->ShowViewContent('header-next-content');?>
                    </div>
                </article>
                <?php $APPLICATION->ShowViewContent('article-next-content');?>
            <?php } ?>
