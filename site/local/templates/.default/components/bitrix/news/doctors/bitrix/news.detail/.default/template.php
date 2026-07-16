<?php

/*
* AlexBazowsky @github
* headachePro bot since aug 2023
*/

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);
global $doctorId;
$doctorId = $arResult['ID'];
?>


<div class="one-doctor-block">
    <div class="wrapper">
        <div itemscope itemtype="http://schema.org/Physician" class="our-doctor-item bgdefault <?=($arResult["NAME"] != 'Ласков') ?: 'flag'?>">
            <link itemprop="url" href="https://<?=SITE_SERVER_NAME?><?=$APPLICATION->GetCurPage()?>">
            <div class="head">
                <div class="up">
                    <span class="img">
                        <img src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arResult["PROPERTIES"]["FIRST_NAME"]["VALUE"]?> <?=$arResult["PROPERTIES"]["MID_NAME"]["VALUE"]?> <?=$arResult["NAME"]?>">
                    </span>
                    <span itemprop="name" class="name">
                        <?=$arResult["PROPERTIES"]["FIRST_NAME"]["VALUE"]?> <?=$arResult["PROPERTIES"]["MID_NAME"]["VALUE"]?> <em><?=$arResult["NAME"]?></em>
                    </span>
                    <small itemprop="description">
                        <?=$arResult["PROPERTIES"]["TITLE"]["VALUE"]?>
                    </small>
                </div>
            </div>

            <div class="cont text-block">
                <?=$arResult["DETAIL_TEXT"]?>
            </div>

            <div class="foot">
                <?php
                $frame = $this->createFrame()->begin();
                ?>
                <span class="subtitle mb-175">Записаться на консультацию</span>
                <?php if ($arResult['schedule'] != false) { ?>
                    <div class="doctor-nearest-time-info-big">Ближайшее свободное время: <?=$arResult['schedule']?></div>
                    <?php if (!empty($arResult["PROPERTIES"]["PRICE_CLINIC"]["VALUE"])) { ?>
                        <button class="show-modal-order-reference-date-modal record-button" data-id="<?=$arResult['ID']?>" onclick="ShowPersonalDoctorPopup(<?=$arResult['ID']?>);">
                            <span class="f-11">Встреча в клинике</span>
                            <span class="price"><?=$arResult["PROPERTIES"]["PRICE_CLINIC"]["VALUE"]?></span>
                            <small>Записаться</small>
                        </button>
                    <?php } ?>
                    <?php if (!empty($arResult["PROPERTIES"]["PRICE_ONLINE"]["VALUE"])) { ?>
                        <button class="show-modal-order-reference-date-modal record-button" data-id="<?=$arResult['ID']?>" onclick="ShowPersonalDoctorPopup(<?=$arResult['ID']?>);">
                            <span class="f-11">Онлайн консультация</span>
                            <span class="price"><?=$arResult["PROPERTIES"]["PRICE_ONLINE"]["VALUE"]?></span>
                            <small>Записаться</small>
                        </button>
                    <?php } ?>
                <?php } else { ?>
                    <div class="doctor-nearest-time-info-big">Для записи позвоните нам или оставьте номер</div>
                    <?php if (!empty($arResult["PROPERTIES"]["PRICE_CLINIC"]["VALUE"])) { ?>
                        <button class="-reference-date-modal" data-id="<?=$arResult['ID']?>" onclick="ShowPersonalDoctorPopup(<?=$arResult['ID']?>);">
                            <span class="f-11">Встреча в клинике</span>
                            <span class="price"><?=$arResult["PROPERTIES"]["PRICE_CLINIC"]["VALUE"]?></span>
                            <small>Заказать&nbsp;звонок</small>
                        </button>
                    <?php } ?>
                    <?php if (!empty($arResult["PROPERTIES"]["PRICE_ONLINE"]["VALUE"])) { ?>
                        <button class="-reference-date-modal" data-id="<?=$arResult['ID']?>" onclick="ShowPersonalDoctorPopup(<?=$arResult['ID']?>);">
                            <span class="f-11">Онлайн консультация</span>
                            <span class="price"><?=$arResult["PROPERTIES"]["PRICE_ONLINE"]["VALUE"]?></span>
                            <small>Заказать&nbsp;звонок</small>
                        </button>
                    <?php } ?>
                <?php } ?>
                <?php
                $frame->end();
                ?>

                <?=$arResult['PROPERTIES']['PRODOCTOROV']['~VALUE']['TEXT'] ?? ''?>

            </div>
        </div>
    </div>
</div>

<section class="title-block doctor-services-price-block">
    <div class="wrapper">
        <div class="gray-block">
            <h2 class="title">
                <?=$arResult["PROPERTIES"]["FIRST_NAME"]["VALUE"]?> <?=$arResult["NAME"]?>: стоимость услуг
            </h2>
            <div class="doctor-services-price-slider slick-slider slick-arrows-default">
