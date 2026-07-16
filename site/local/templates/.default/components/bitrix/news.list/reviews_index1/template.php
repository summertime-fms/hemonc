<?php

/*
* AlexBazowsky @github
* for Headache since aug 2024
*/

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}
?>

<section class="about-rows-feedbacks bgdefault title-link-block">
    <h2>
        <a href="/about-us/feedback-friends/">Отзывы</a>
    </h2>
    <div class="feedback-link-container">
        <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
            <a href="/about-us/feedback-friends/" class="feedback-link-item">
                <span class="img"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>"></span>
                <span class="name"><?=$arItem["NAME"]?></span>
            </a>
        <?php } ?>
    </div>
</section>