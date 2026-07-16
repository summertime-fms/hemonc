<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2024
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}
?>

<div class="t-h2">
    <a href="/about-us/our-doctors/">
        Наши врачи
    </a>
</div>

<div class="doctor-link-container">
    <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="doctor-link-item">
            <span class="img">
                <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="">
            </span>
            <span class="name">
                <?=$arItem["PROPERTIES"]["FIRST_NAME"]["VALUE"]?>
                <?=$arItem["PROPERTIES"]["MID_NAME"]["VALUE"]?>
                <?=$arItem["NAME"]?>
            </span>
                <small>
                    <?=$arItem["PROPERTIES"]["TITLE"]["VALUE"]?>
                </small>
            </a>
    <?php }?>
</div>