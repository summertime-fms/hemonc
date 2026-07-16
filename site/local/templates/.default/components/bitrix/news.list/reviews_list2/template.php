<?php

/*
* AlexBazowsky @github
* for Headache since aug 2024
*/

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}
?>

<div class="reviews-list-block">
    <div class="wrapper">
        <div class="reviews-list-nav">
            <a href="/about-us/feedback-friends/" class="active">Друзья</a>
            <a href="/about-us/reviews-patients/">Пациенты</a>
        </div>
        <div id="page_elements_container" class="grid-row-root reviews-list-container masonry" data-masonry='{ "resize": true }'>
            <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
                <article id="page_elements_item" class="reviews-list-item bgdefault" itemscope itemtype="http://schema.org/Review">
                    <meta itemprop="itemReviewed" content="Клиника доктора Ласкова">
                    <div class="head-big">
                        <div class="img"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>"></div>
                        <span itemprop="author" class="name"><?=$arItem["NAME"]?></span>
                        <small>
                            <?=$arItem['PROPERTIES']["TITLE"]["VALUE"]?>
                        </small>
                    </div>
                    <div class="text-block" itemprop="reviewBody">
                        <?=$arItem['DETAIL_TEXT']?>
                    </div>
                </article>
            <?php } ?>
        </div>
    </div>
</div>
<?php if ($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?php endif;?>