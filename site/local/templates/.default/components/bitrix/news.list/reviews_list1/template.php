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
    <a href="/about-us/feedback-friends/">Отзывы</a>
</div>
<div class="feedback-link-container">
    <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
        <a href="/about-us/feedback-friends/" class="feedback-link-item">
            <span class="img">
                <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>">
            </span>
            <span class="name"><?=$arItem["NAME"]?></span>
        </a>
    <?php } ?>
</div>