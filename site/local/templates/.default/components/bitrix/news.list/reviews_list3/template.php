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
            <a href="/about-us/feedback-friends/">Друзья</a>
            <a href="/about-us/reviews-patients/" class="active">Пациенты</a>
        </div>
        <div id="page_elements_container" class="grid-row-root reviews-list-container masonry" data-masonry='{ "resize": true }'>
            <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
                <article id="page_elements_item" class="reviews-list-item bgdefault" itemscope itemtype="http://schema.org/Review">
                    <div class="head">
                        <span itemprop="author" class="name"><?=$arItem["NAME"]?></span>
                        <small></small>
                        <a href="<?=$arItem['PROPERTIES']["TITLE"]["VALUE"]?>" target="_blank" rel="noopener nofollow">Читать источник</a>
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