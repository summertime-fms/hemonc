<?php

/*
* AlexBazowsky @github
* headachePro bot since aug 2023
*/

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);
?>
    <div class="wrapper">
        <div class="default-main-block-content">
            <div itemscope itemtype="http://schema.org/Service" class="grid-row-root grid-row grid-row-flex cols-b2 cols-m1">
                <div class="grid-col bgdefault text-block">
                    <meta itemprop="name" content="<?=$arResult['NAME']?>"/>
                    <meta itemprop="description" content="<?=htmlspecialchars($arResult['IPROPERTY_VALUES']['ELEMENT_META_DESCRIPTION'] ?? '', ENT_QUOTES | ENT_HTML5, defined('SITE_CHARSET') ? SITE_CHARSET : 'UTF-8')?>">

                    <?=$arResult['DETAIL_TEXT']?>


                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <meta itemprop="priceCurrency" content="RUB"/>

                        <meta itemprop="availability" href="http://schema.org/InStock"/>
                        <?php if (
                            $arResult['PROPERTIES']['PRICE']['MIN_VALUE']
                            && $arResult['PROPERTIES']['PRICE']['MAX_VALUE']
                        ) { ?>
                            <div>
                                Цена: <span itemprop="price">
                                <?=$arResult['PROPERTIES']['PRICE']['MIN_VALUE']?>
                            </span> - <span itemprop="price">
                                <?=$arResult['PROPERTIES']['PRICE']['MAX_VALUE']?>
                            </span> руб.
                            </div>
                        <?php } else { ?>
                            <div style="display: none;">
                                Цена: <span itemprop="price">5500</span> руб.
                            </div>
                        <?php } ?>
                    </div>

                    <div class="reviews-block">
                        <div class="pointer-widget-container" data-src="https://rf.pntr.io/d19c684c-5de4-451b-a60d-6a07dd43bfa3"></div>
                        <script src="https://storage.yandexcloud.net/rf-pntr-io/js/widget.js"></script>
                    </div>

                    <div class="inline-container">
                        <?php $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            [
                                "PATH"           => SITE_TEMPLATE_PATH . "/parts/bitrixCallback.php",
                                "AREA_FILE_SHOW" => "file",
                            ],
                ); ?>
                    </div>
                </div>
                <div id="right-clmn" class="grid-col inner-video bgdefault">
                    <?php if ($arResult['PREVIEW_PICTURE']['SRC']) { ?>
                        <p>
                            <img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']?>" itemprop="image"/>
                        </p>
                    <?php } ?>
                    <?php if ($arResult['PREVIEW_TEXT']) { ?>
                        <p>
                            <?=$arResult['PREVIEW_TEXT']?>
                        </p>
                    <?php } ?>
                    <div id="blog-list" class="blog-aside">
                        <?php foreach ($arResult['OTHER_FEEDS'] as $otherFeed) {?>
                            <a href="<?=$otherFeed['DETAIL_PAGE_URL']?>" title="<?=$otherFeed['NAME']?>">
                                <span class="span"><?=$otherFeed['NAME']?></span>
                                <span class="time"><?=$otherFeed['DISPLAY_ACTIVE_FROM']?></span>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php \Bitrix\Main\Page\Asset::getInstance()->addJs("/services/detail.js"); ?>

<?php if (count($arResult['DOCTORS'])) : ?>
    <section class="title-block reception-block">
        <div class="wrapper">
            <div class="gray-block">
                <h2 class="title">Запись на прием</h2>
                <div class="row">
                    <div>
                        <p>
                            Если вы решили записаться на консультацию или процедуру, выберите врача, дату, время и оставьте контактный телефон.
                            Наши администраторы свяжутся с вами течение часа и запишут. С этого момента вы будете не одни!
                        </p>
                    </div>
                    <div>
                        <div class="slick-slider reception-slider visible <?=$arResult['currentDoc'] ?: 'visible'?>" style="display: block; <?=$arResult['currentDoc'] ?: 'display: block;'?>">
                            <?php foreach ($arResult['DOCTORS'] as $arDoctor) {?>
                                <?php if ($arResult['currentDoc'] && $arResult['currentDoc']['ID'] != $arDoctor['ID']) {
                                    continue;
                                } ?>

                                <div
                                        class="show-modal-order-reference-date-modal reception-doctor-item reception-doctor-item-ajax <?=($arDoctor["NAME"] != 'Ласков') ?: 'flag'?>"
                                        data-id="<?=$arDoctor['ID']?>"
                                        data-type="phone"
                                        data-price="<?=$arDoctor['PROPERTY_PRICE_CLINIC_VALUE']?>"
                                    <?php // if ($arDoctor["schedule"]) : ?>
                                        onclick="ShowPersonalDoctorPopup(<?=$arDoctor['ID']?>);"
                                    <?php // endif; ?>
                                >
                                <span class="img">
                                    <img src="<?=$arDoctor['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arDoctor['NAME']?>">
                                </span>
                                    <span class="name">
                                    <b>
                                        <?=$arDoctor["NAME"]?>
                                    </b>
                                    <br/>
                                    <?=$arDoctor["PROPERTY_FIRST_NAME_VALUE"]?>
                                    <br/>
                                    <?=$arDoctor["PROPERTY_MID_NAME_VALUE"]?>
                                </span>
                                    <span class="price">
                                    <?=$arDoctor['PROPERTY_PRICE_CLINIC_VALUE']?>
                                </span>
                                    <?php
                                    $frame = $this->createFrame()->begin();
                                    $frame->setAnimation(true);
                                    ?>
                                    <?php if ($arDoctor["schedule"]) : ?>
                                        <span class="sel">Запись онлайн</span>
                                    <?php else : ?>
                                        <span class="sel">Запись по телефону</span>
                                    <?php endif; ?>
                                    <?php
                                    $frame->end();
                                    ?>
                                </div>

                            <?php }?>
                        </div>
                        <div class="set-time-block set-time-block-load"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>