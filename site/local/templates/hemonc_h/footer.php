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

        <?php if (!\CSite::InDir(SITE_DIR . 'index.php')) { ?>
                <div class="wrapper">

                </div>
        <?php } ?>

        <footer class="footer" itemscope itemtype="http://schema.org/WPFooter">
            <meta itemprop="copyrightYear" content="<?=date('Y')?>">
            <meta itemprop="copyrightHolder" content="Клиника доктора Ласкова">

            <div class="center-wrap">
                <div class="footer__row">
                    <div class="footer__content">
                        <a href="/" class="header__logo">
                            <span>— </span>
                            Клиника доктора Ласкова<span>.</span>
                        </a>
                        <div class="footer__timetable" style="color: #ffffff">
                            <?=\Hemonc\Params::p('footer_raspisanie')?>
                        </div>
                        <div class="footer__support">
                            <?php $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "PATH"           => SITE_TEMPLATE_PATH . "/parts/yaSprav.php",
                                    "AREA_FILE_SHOW" => "file",
                                ],
                            )?>
                        </div>
                    </div>
                    <div class="footer__menu">
                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "footer_v2_desktop",
                            [
                                "ROOT_MENU_TYPE"        => "footer_desktop_left",
                                "CHILD_MENU_TYPE"       => "footer_desktop_left_sub",
                                "MAX_LEVEL"             => "4",
                                "USE_EXT"               => "N",
                                "MENU_CACHE_TYPE"       => "A",
                                "MENU_CACHE_TIME"       => "3600",
                                "MENU_CACHE_USE_GROUPS" => "N",
                                "MENU_CACHE_GET_VARS"   => [
                                ],
                                "COMPONENT_TEMPLATE" => "footer_v2_desktop",
                                "DELAY"              => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                            ],
                            false,
                        );?>

                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "footer_v2_desktop",
                            [
                                "ROOT_MENU_TYPE"        => "footer_desktop_center",
                                "CHILD_MENU_TYPE"       => "footer_desktop_center_sub",
                                "MAX_LEVEL"             => "4",
                                "USE_EXT"               => "N",
                                "MENU_CACHE_TYPE"       => "A",
                                "MENU_CACHE_TIME"       => "3600",
                                "MENU_CACHE_USE_GROUPS" => "N",
                                "MENU_CACHE_GET_VARS"   => [
                                ],
                                "COMPONENT_TEMPLATE" => "footer_v2_desktop",
                                "DELAY"              => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                            ],
                            false,
                        );?>

                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "footer_v2_desktop",
                            [
                                "ROOT_MENU_TYPE"        => "footer_desktop_right",
                                "CHILD_MENU_TYPE"       => "footer_desktop_right_sub",
                                "MAX_LEVEL"             => "4",
                                "USE_EXT"               => "N",
                                "MENU_CACHE_TYPE"       => "A",
                                "MENU_CACHE_TIME"       => "3600",
                                "MENU_CACHE_USE_GROUPS" => "N",
                                "MENU_CACHE_GET_VARS"   => [
                                ],
                                "COMPONENT_TEMPLATE" => "footer_v2_desktop",
                                "DELAY"              => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                            ],
                            false,
                        );?>
                    </div>

                    <div class="footer__mob">
                        <div class="footer__mob-item">
                            <div class="footer__mob-title">Меню</div>
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
                                    "COMPONENT_TEMPLATE" => "footer_v2_mobile",
                                    "DELAY"              => "N",
                                    "ALLOW_MULTI_SELECT" => "N",
                                ],
                                false,
                            );?>
                        </div>

                        <div class="footer__mob-item">
                            <?=\Hemonc\Params::p('footer_mobile_raspisanie')?>

                            <?php $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                [
                                    "PATH"           => SITE_TEMPLATE_PATH . "/parts/yaSprav.php",
                                    "AREA_FILE_SHOW" => "file",
                                ],
                            )?>
                        </div>
                    </div>
                    <div class="footer__info">
                        <a href="#" class="footer__btn btn" onclick="SelectDoctorPopup()">Запись на прием</a>
                        <div class="footer__info-links">
                            <a href="tel:<?=preg_replace('/[\(\)\s-]/', '', \Hemonc\Params::p('phone'))?>" class="header__phone"><?=\Hemonc\Params::p('phone')?></a>
                            <a href="<?=\Hemonc\Params::p('header_address_link')?>" target="_blank" rel="noopener nofollow" class="header__addy"><?=\Hemonc\Params::p('address')?></a>
                            <a href="mailto:<?=\Hemonc\Params::p('email')?>" class="header__mail"><?=\Hemonc\Params::p('email')?></a>
                        </div>
                        <div class="footer__contacts">
                            <a href="<?=\Hemonc\Params::p('tg_link')?>" class="header__icon --tg"></a>
                            <a href="<?=\Hemonc\Params::p('vk_link')?>" class="header__icon --vk"></a>
<!--                            <a href="--><?php //=\Hemonc\Params::p('max_link')?><!--" class="header__icon --max"></a>-->
                            <a href="<?=\Hemonc\Params::p('yt_link')?>" class="header__icon --yt"></a>
                        </div>
                    </div>
                </div>
                <div class="footer__bottom">
                    <div class="footer__copy">© <?=date('Y')?>,&nbsp;Клиника доктора Ласкова.</div>
                    <!-- <a href="" class="footer__policy">Политика конфиденциальности</a> -->
                </div>
            </div>
        </footer>
    </div>

    <div class="modal-content reference-modal" id="referenceDateModal"></div>
    <div class="modal-content reference-modal" id="referenceMailModal">
        <?php $APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            [
                "PATH"           => SITE_TEMPLATE_PATH . "/parts/header_callbackForm.php",
                "AREA_FILE_SHOW" => "file",
            ],
        )?>
    </div>

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
