<?php

/*
* AlexBazowsky @github
* for Headache since aug 2024
*/

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit();
}
?>
<div class="wrapper">
    <?php $APPLICATION->ShowViewContent('footer-content');?>
</div>
        </main>
        <div class="bottom-address title-block for-small">
            <div class="gray-block">
                <div class="wrap-s">
                    <span class="title">Контакты</span>
                    <p>
                        <span class="subtitle">АДРЕС</span>
                    </p>
                    <p class="p1">
                        <?=\Hemonc\Params::p('address')?>
                    </p>
                    <p class="p1">
                        <br>
                        <span class="subtitle">РЕЖИМ РАБОТЫ</span>
                    </p>
                    <p>
                        <?=\Hemonc\Params::p('schedule')?>
                    </p>
                    <p>&nbsp;</p>
                    <p>Запись на прием</p>
                    <p>
                        <span class="call_phone_4">
                            <a href="tel:<?=\str_replace(['(', ')', '-', ' '], '', \Hemonc\Params::p('phone'))?>"><?=\Hemonc\Params::p('phone')?></a>
                        </span>
                    </p>
                    <p>&nbsp;</p>
                    <p>Отправить документы врачам</p>
                    <p>
                        <a href="mailto:<?=\Hemonc\Params::p('email')?>"><?=\Hemonc\Params::p('email')?></a>
                    </p>
                    <p>&nbsp;</p>
                    <p>По вопросам сотрудничества</p>
                    <p>
                        <a href="mailto:<?=\Hemonc\Params::p('email-partners')?>"><?=\Hemonc\Params::p('email-partners')?></a>
                    </p>
                </div>
            </div>
        </div>

        <div class="bottom-contacts title-block for-small">
            <div class="gray-block">
                <div class="wrap-s">
                    <span class="title">Связаться с нами</span>
                    <div class="row main-block-load-bottom-contacts main-block-load">
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

        <footer class="page-footer" itemscope itemtype="https://schema.org/WPFooter" >
            <meta itemprop="copyrightYear" content="<?=date('Y')?>">
            <meta itemprop="copyrightHolder" content="Клиника доктора Ласкова">

            <div class="wrapper">
                <div class="page-footer-social">
                    <a href="<?=\Hemonc\Params::p('yt_link')?>" target="_blank" class="yt" rel="nofollow noreferrer"></a>
                    <a href="<?=\Hemonc\Params::p('vk_link')?>" target="_blank" class="vk" rel="nofollow noreferrer"></a>
                    <a href="<?=\Hemonc\Params::p('tg_link')?>" target="_blank" class="tg" rel="nofollow noreferrer"></a>
                </div>

                <div class="page-footer-nav">
                    <?php $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "footer_main",
                        [
                            "ROOT_MENU_TYPE"        => "bot",
                            "MAX_LEVEL"             => "4",
                            "USE_EXT"               => "N",
                            "MENU_CACHE_TYPE"       => "A",
                            "MENU_CACHE_TIME"       => "3600",
                            "MENU_CACHE_USE_GROUPS" => "N",
                            "MENU_CACHE_GET_VARS"   => [
                            ],
                            "COMPONENT_TEMPLATE" => "footer_main",
                            "DELAY"              => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                        ],
                        false,
                    );?>
                    <div class="for-small mb-24">
                        <iframe src="https://yandex.ru/sprav/widget/rating-badge/124211366467?type=rating" width="150" height="50"></iframe>
                    </div>

                    <meta itemprop="copyrightYear" content="<?=date('Y')?>">
                    <meta itemprop="copyrightHolder" content="Клиника доктора Ласкова">

                    <p class="dev">
                        <span>© <?=date('Y')?>,</span> Клиника доктора Ласкова.
                    </p>        
                </div>
            </div>
        </footer>
    </div>

    <div class="modal-content reference-modal" id="referenceDateModal"></div>
    <div class="modal-content reference-modal" id="referenceMailModal"></div>

    <div class="doctors-popup-bg">
        <div class="doctors-popup-content">
            <div class="popup-loading">
                <div class="floatingBarsG floatingBarsG-modal-default">
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

    <div class="loading-block-hidden">
        <div class="popup-loading">
            <div class="floatingBarsG floatingBarsG-modal-default">
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

    <script>
        $(document).ready(function () {
            if ($('.slick-slider').length > 0) {
                $('.slick-slider').fadeIn();
            }

            $(window).scroll(function () {
                onWindowScroll();
            });

            checkCookiesInfo();
        });

        function onWindowScroll() {
            if (screen.width > 500 || $('#mobile-maps').length === 0) {
                return;
            }
            var posY = $('#mobile-maps').position().top;
            if ($(window).scrollTop() > posY - 500) {
                if ($('#mobile-maps').data('ready') === false) {
                    $('#mobile-maps').data('ready', true);
                    $('iframe#ma').attr('src', 'https://yandex.ru/map-widget/v1/?um=constructor%3Aeb79d98a19062654c6a21bd567f728f8b1851938916f13191ba073c212c8d65a&amp;source=constructor');
                    $('iframe#mb').attr('src', 'https://yandex.ru/map-widget/v1/?um=constructor%3A9aba82a32d146e5f78c4a1e6bc5bfaa0a0f90d93a607d638f2cb783ec5ea6579&amp;source=constructor');
                    $('iframe#mc').attr('src', 'https://yandex.ru/map-widget/v1/?um=constructor%3Adb1285349e2bad73e9fa9bccb876282d00dde124a5fd7f91504ed1c5fc283645&amp;source=constructor');
                    $('iframe#md').attr('src', 'https://yandex.ru/map-widget/v1/?um=constructor%3Ad76ac9028edcb4d68f5014fee6fbc32b9f75b382a1d7ed29bab553aa58e3bf04&amp;source=constructor');
                }
            }
        }
    </script>

    <?php $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        [
            "PATH"           => SITE_TEMPLATE_PATH . "/parts/googleAnalytics.php",
            "AREA_FILE_SHOW" => "file",
        ],
    )?>

    <?php $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        [
            "PATH"           => SITE_TEMPLATE_PATH . "/parts/yaMetrica.php",
            "AREA_FILE_SHOW" => "file",
        ],
    )?>

    <?php $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        [
            "PATH"           => SITE_TEMPLATE_PATH . "/parts/calltouch.php",
            "AREA_FILE_SHOW" => "file",
        ],
    )?>
    
    <?php $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        [
            "PATH"           => SITE_TEMPLATE_PATH . "/parts/vkPixel.php",
            "AREA_FILE_SHOW" => "file",
        ],
    )?>

    <?php $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        [
            "PATH"           => SITE_TEMPLATE_PATH . "/parts/fbPixel.php",
            "AREA_FILE_SHOW" => "file",
        ],
    )?>

    <?php $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        [
            "PATH"           => SITE_TEMPLATE_PATH . "/parts/bitrixWidget.php",
            "AREA_FILE_SHOW" => "file",
        ],
    )?>

</body>
</html>