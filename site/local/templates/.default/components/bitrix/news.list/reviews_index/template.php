<?php

/*
* AlexBazowsky @github
* for Headache since aug 2024
*/

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);
?>
<section class="recommend-block">
    <h2><a href="/about-us/feedback-friends/">НАС РЕКОМЕНДУЮТ</a></h2>
    <div class="img-slider slick-slider" style="display: none;">
        <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
            <div class="slick-slide">
                <div>
                    <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="">
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="txt-slider slick-slider" style="display: none;">
        <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
            <div>
                <h3><?=$arItem["NAME"]?></h3>
                <small>
                    <?=$arItem['PROPERTIES']["TITLE"]["VALUE"]?>
                </small>
                <p>
                    <?=!empty($arItem["PREVIEW_TEXT"]) ? $arItem["PREVIEW_TEXT"] : $arItem["DETAIL_TEXT"] ?>
                    <a href="/about-us/feedback-friends/">читать полностью</a>
                    </p>
            </div>
        <?php } ?>
    </div>
</section>
