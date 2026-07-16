<?php

/*
* AlexBazowsky @github
* for Headache since aug 2024
*/

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}
?>
<div class="hemonc2__reviews" id="reviews">
    <div class="center-wrap">
        <div class="hemonc2__row">
            <div class="hemonc2__h2">Отзывы</div>
            <a href="/about-us/reviews-patients/" class="hemonc2__link">смотреть все</a>
        </div>
        <div class="hemonc2__reviews-swiper">
        <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
            <div class="hemonc2__reviews-item" itemscope itemtype="http://schema.org/Review">
                <div class="hemonc2__reviews-name" itemprop="author">
                    <?=$arItem["NAME"]?>
                </div>
                <div class="hemonc2__reviews-date">
                    <?=$arItem["DATE_ACTIVE_FROM"]?>
                </div>
                <?php if (intval($arItem['PROPERTIES']["STARS"]["VALUE"]) >= 3) { ?>
                    <div class="hemonc2__reviews-stars">
                        <?php for ($s=1; $s <= intval($arItem['PROPERTIES']["STARS"]["VALUE"]); $s++) { ?>
                            <div class="hemonc2__reviews-star"></div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="hemonc2__reviews-text">
                    <?=$arItem['DETAIL_TEXT']?>
                </div>
                <?php if (!empty($arItem['PROPERTIES']["TITLE"]["VALUE"])) { ?>
                    <a href="<?=$arItem['PROPERTIES']["TITLE"]["VALUE"]?>" target="_blank" rel="noopener nofollow" class="hemonc2__reviews-link hemonc2__link">
                        читать полностью
                    </a>
                <?php } ?>
                <div class="hemonc2__reviews-source">
                    <?=$arItem['PROPERTIES']["REVIEW_LOGO"]["~VALUE"] ?? ''?>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>
</div>

<script>
    $('.hemonc2__reviews-swiper').slick({
        adaptiveHeight: true, 
        mobileFirst: true,
        infinite: true,
        dots: true,
        dotsClass: 'hemonc2__reviews-dots',
        arrows: false,
        slidesToShow: 1,
        swipeToSlide: true,
        // centerMode: true,
        // variableWidth: true,
        responsive: [
            {
                breakpoint: 520,
                settings: {
                    slidesToShow: <?=min(count($arResult['ITEMS']), 2)?>,
                }
            },{
                breakpoint: 767,
                settings: {
                    slidesToShow: <?=min(count($arResult['ITEMS']), 3)?>,
                }
            },{
                breakpoint: 1199,
                settings: {
                    slidesToShow: <?=min(count($arResult['ITEMS']), 4)?>,
                }
            }
        ]
    });
</script>