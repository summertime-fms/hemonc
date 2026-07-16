<?php

/*
* AlexBazowsky @github
* for Headache since aug 2024
*/

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit();
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
// $APPLICATION->ShowPanel();
?>
<!doctype html>
<html lang="ru">

    <head itemscope itemtype="http://schema.org/WPHeader">
        <?php $APPLICATION->ShowHead();?>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="format-detection" content="telephone=no">
        <meta name="copyright" lang="ru" content="Клиника доктора Ласкова">
        <meta name="author" content="">

        <title itemprop="headline"><?php $APPLICATION->ShowTitle()?></title>

        <meta name="facebook-domain-verification" content="vbgom8ltvizpvt0vb9u613t8t5xn3n">
        <meta name="mailru-verification" content="3932c95ba23f19b2">
        <meta name="yandex-verification" content="805feffd3a6b717a">

        <link rel="shortcut icon" href="/favicon.ico">

        <!-- <link rel="preconnect" href="https://i.ytimg.com"> -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <!-- <link rel="preconnect" href="https://www.youtube.com"> -->
        <link rel="preconnect" href="https://mod.calltouch.ru">

        <?php
        \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/bootstrap-grid.css");
        \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/fonts.css");
        \Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/site-f.css");

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
        ?>
    </head>

    <body
        class="<?=(\CSite::InDir(SITE_DIR . 'index.php')) ? 'main-page ' : $APPLICATION->ShowViewContent('body-class')?>">
        <?=$APPLICATION->ShowPanel()?>

        <div style="display:none;" itemscope itemtype="http://schema.org/Organization">
            <div style="display:none;" itemprop="name">Клиника доктора Ласкова</div>
            <link style="display:none;" itemprop="url" href="/">
            <div style="display:none;" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                    <span style="display:none;" itemprop="postalCode">117556</span>,
                    <span style="display:none;" itemprop="addressCountry">Россия</span>, 
                    <span style="display:none;" itemprop="addressLocality">Москва</span>, 
                    <span style="display:none;" itemprop="streetAddress">ул. Болотниковская д.3 к.1</span>
            </div>
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

            <header class="page-header">
                <div class="page-header-main">
                    <div class="wrapper">
                        <a href="/" class="logo-new for-big">
                            <span class="m-red">&mdash;</span>Клиника доктора Ласкова<span class="m-red">.</span>
                        </a>

                        <a href="/" class="not-big">
                            <img src="<?=SITE_TEMPLATE_PATH?>/images/logo-small.png" class="small-logo" width="100" height="100" alt="logo image">
                        </a>

                        <nav class="for-big" itemscope="" itemtype="https://schema.org/SiteNavigationElement">
                            <?php $APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "header_main",
                                [
                                    "ROOT_MENU_TYPE"        => "top",
                                    "MAX_LEVEL"             => "4",
                                    "USE_EXT"               => "N",
                                    "MENU_CACHE_TYPE"       => "A",
                                    "MENU_CACHE_TIME"       => "3600",
                                    "MENU_CACHE_USE_GROUPS" => "N",
                                    "MENU_CACHE_GET_VARS"   => [
                                    ],
                                    "COMPONENT_TEMPLATE" => "header_main",
                                    "DELAY"              => "N",
                                    "ALLOW_MULTI_SELECT" => "N",
                                ],
                                false,
                            );?>
                        </nav>

                        <span class="call_phone_3">
                            <a href="tel:<?=\str_replace(['(', ')', '-', ' '], '', \Hemonc\Params::p('phone'))?>"
                                class="not-small"><?=\Hemonc\Params::p('phone')?></a>
                        </span>

                        <p class="for-big">
                            <a class="red-button red-button-big-text" onclick="SelectDoctorPopup()">Запись на прием</a>
                        </p>

                        <p class="not-big">
                            <a class="red-button red-button-big-text-mobile" onclick="SelectDoctorPopup()">Записаться</a>
                        </p>

                        <button class="burger not-big"></button>
                    </div>
                </div>

                <div class="not-big page-header-popup page-header-contacts">
                    <div class="scroll-container">
                        <div class="wrapper">
                            <span class="title">Запись на консультацию</span>
                            <div class="gray-block">
                                <p>Звоните нам по номеру</p>
                                <span class="call_phone_4">
                                    <a href="tel:<?=\str_replace(['(', ')', '-', ' '], '', \Hemonc\Params::p('phone'))?>"><?=\Hemonc\Params::p('phone')?></a>
                                </span>
                                <p>Пишите на почту</p>
                                <a href="mailto:<?=\Hemonc\Params::p('email')?>"><?=\Hemonc\Params::p('email')?></a>
                                <div class="main-block-load-page-header-contacts-popup-contacts main-block-load">
                                    <p>
                                        Или заполните форму ниже, чтобы мы перезвонили Вам.
                                    </p>
                                    <?php $APPLICATION->IncludeComponent(
                                        "bitrix:main.include",
                                        "",
                                        [
                                            "PATH"           => SITE_TEMPLATE_PATH . "/parts/header_callbackForm.php",
                                            "AREA_FILE_SHOW" => "file",
                                        ],
                                    )?>

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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="not-big page-header-popup page-header-menu">
                    <div class="scroll-container">
                        <div class="wrap-m">
                            <div class="wrap-s">
                                <div class="menu-phone">
                                    <a href="tel:<?=\str_replace(['(', ')', '-', ' '], '', \Hemonc\Params::p('phone'))?>"><?=\Hemonc\Params::p('phone')?></a>
                                </div>
                                <div>
                                    <?php $APPLICATION->IncludeComponent(
                                        "bitrix:menu",
                                        "header_mobile",
                                        [
                                            "ROOT_MENU_TYPE"        => "topmobile",
                                            "MAX_LEVEL"             => "4",
                                            "USE_EXT"               => "N",
                                            "MENU_CACHE_TYPE"       => "A",
                                            "MENU_CACHE_TIME"       => "3600",
                                            "MENU_CACHE_USE_GROUPS" => "N",
                                            "MENU_CACHE_GET_VARS"   => [
                                            ],
                                            "COMPONENT_TEMPLATE" => "header_main",
                                            "DELAY"              => "N",
                                            "ALLOW_MULTI_SELECT" => "N",
                                        ],
                                        false,
                                    );?>
                                </div>

                                <div class="address">
                                    <div>
                                        <span class="subtitle">АДРЕС</span>
                                        <p>
                                            <?=\Hemonc\Params::p('address')?>
                                        </p>
                                    </div>
                                    <div>
                                        <span class="subtitle">КОНТАКТЫ</span>
                                        <p>
                                            <span class="call_phone_4">
                                                <a href="tel:<?=\str_replace(['(', ')', '-', ' '], '', \Hemonc\Params::p('phone'))?>"><?=\Hemonc\Params::p('phone')?></a>
                                            </span><br>
                                            <a href="mailto:<?=\Hemonc\Params::p('email')?>"><?=\Hemonc\Params::p('email')?></a>
                                        </p>
                                    </div>
                                    <div>
                                        <span class="subtitle">ПО ВОПРОСАМ СОТРУДНИЧЕСТВА</span>
                                        <p>
                                            <a href="mailto:<?=\Hemonc\Params::p('email-partners')?>"><?=\Hemonc\Params::p('email-partners')?></a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="bottom-contacts title-block">
                                <div class="gray-block">
                                    <div class="wrap-s">
                                        <span class="title">Связаться с нами</span>
                                        <div class="row main-block-load-header-contacts main-block-load">
                                            <div>
                                                <p>
                                                    <span style="font-weight: 400;">
                                                        Мы считаем, что общаться с пациентами так же важно, как поставить диагноз или сделать «карту» лечения.
                                                    </span>
                                                    <span style="font-weight: 400;">
                                                        Поэтому, если у вас остались вопросы или вы хотите записаться на прием к специалисту, оставьте <strong>свой</strong> номер телефона, и мы свяжемся с вами в течение часа.
                                                    </span>
                                                </p>
                                            </div>
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

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </header>
            <main>
            <?php
            if (!\CSite::InDir(SITE_DIR . 'index.php')) { ?>
                <article class="default-main-block">
                    <div class="wrapper">
                        <header class="<?=$APPLICATION->ShowViewContent('header-class')?>">
                            <h1><?=$APPLICATION->ShowTitle(false)?></h1>
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
