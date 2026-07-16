<?php

/*
* AlexBazowsky @github
* headachePro bot since aug 2023
*/

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);
?>
<div class="our-doctors-block">
    <div class="wrapper">
        <div class="grid-row-root">
            <?php foreach($arResult["ITEMS"] as $arItem) { ?>
                <div class="our-doctor-item bgdefault <?=($arItem["NAME"] != 'Ласков') ?: 'flag'?>">
                    <div class="head">
                        <div class="up">
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="img">
                                <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PROPERTIES"]["FIRST_NAME"]["VALUE"]?> <?=$arItem["PROPERTIES"]["MID_NAME"]["VALUE"]?> <?=$arItem["NAME"]?>">
                            </a>
                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="name">
                                <?=$arItem["PROPERTIES"]["FIRST_NAME"]["VALUE"]?> <?=$arItem["PROPERTIES"]["MID_NAME"]["VALUE"]?> <em><?=$arItem["NAME"]?></em>
                            </a>
                            <small>
                                <?=$arItem["PROPERTIES"]["TITLE"]["VALUE"]?>
                            </small>
                        </div>
                    </div>

                    <div class="cont">
                        <?=$arItem["PREVIEW_TEXT"]?>
                    </div>

                    <div class="foot">
                        <?php 
                            $frame = $this->createFrame()->begin();
                        ?>
                        <span class="subtitle">Записаться на консультацию</span>
                        <?php if ($arItem['schedule'] != false) { ?>
                            <div class="doctor-nearest-time-info-big">Ближайшее свободное время: <?=$arItem['schedule']?></div>
                                <?php if (!empty($arItem["PROPERTIES"]["PRICE_CLINIC"]["VALUE"])) { ?>
                                    <button class="show-modal-order-reference-date-modal" data-id="<?=$arItem['ID']?>" onclick="ShowPersonalDoctorPopup(<?=$arItem['ID']?>);">
                                        <span class="f-11">Встреча в клинике</span>
                                        <span class="price"><?=$arItem["PROPERTIES"]["PRICE_CLINIC"]["VALUE"]?></span>
                                            <small>Записаться</small>
                                    </button>
                                <?php } ?>
                                <?php if (!empty($arItem["PROPERTIES"]["PRICE_ONLINE"]["VALUE"])) { ?>
                                    <button class="show-modal-order-reference-date-modal" data-id="<?=$arItem['ID']?>" onclick="ShowPersonalDoctorPopup(<?=$arItem['ID']?>);">
                                        <span class="f-11">Онлайн консультация</span>
                                        <span class="price"><?=$arItem["PROPERTIES"]["PRICE_ONLINE"]["VALUE"]?></span>
                                            <small>Записаться</small>
                                    </button>
                                <?php } ?>
                        <?php } else { ?>
                            <div class="doctor-nearest-time-info-big">Для записи позвоните нам или оставьте номер</div>
                            <?php if (!empty($arItem["PROPERTIES"]["PRICE_CLINIC"]["VALUE"])) { ?>
                                    <button class="-reference-date-modal" data-id="<?=$arItem['ID']?>" onclick="ShowPersonalDoctorPopup(<?=$arItem['ID']?>);">
                                        <span class="f-11">Встреча в клинике</span>
                                        <span class="price"><?=$arItem["PROPERTIES"]["PRICE_CLINIC"]["VALUE"]?></span>
                                            <small>Заказать&nbsp;звонок</small>
                                    </button>
                                <?php } ?>
                                <?php if (!empty($arItem["PROPERTIES"]["PRICE_ONLINE"]["VALUE"])) { ?>
                                    <button class="-reference-date-modal" data-id="<?=$arItem['ID']?>" onclick="ShowPersonalDoctorPopup(<?=$arItem['ID']?>);">
                                        <span class="f-11">Онлайн консультация</span>
                                        <span class="price"><?=$arItem["PROPERTIES"]["PRICE_ONLINE"]["VALUE"]?></span>
                                            <small>Заказать&nbsp;звонок</small>
                                    </button>
                                <?php } ?>
                        <?php } ?>
                        <?php
                            $frame->end();
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
