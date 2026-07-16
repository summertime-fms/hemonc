<?php

/*
* AlexBazowsky @github
* for Headache since aug 2024
*/

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}
?>

<div class="center-wrap ">
    <div class="hemonc2__advantages">
        <div class="hemonc2__row">
            <div class="hemonc2__h2">Преимущества клиники</div>
            <a href="/about-us/" class="hemonc2__link">о клинике</a>
        </div>
        <div class="hemonc2__advantages-swiper">
            <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
                <div class="hemonc2__advantages-item">
                    <div class="hemonc2__advantages-icon">
                        <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem['PREVIEW_TEXT']?>">
                    </div>
                    <div class="hemonc2__advantages-text">
                        <?=$arItem['PREVIEW_TEXT']?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    $('.hemonc2__advantages-swiper').slick({
        adaptiveHeight: false, 
        mobileFirst: true,
        infinite: true,
        dots: true,
        dotsClass: 'hemonc2__advantages-dots',
        arrows: false,
        slidesToShow: 1,
        swipeToSlide: true,
        centerMode: true,
        variableWidth: true,
        responsive: [
            {
                breakpoint: 320,
                settings: {
                    slidesToShow: <?=min(count($arResult['ITEMS']), 3)?>,
                }
            },{
                breakpoint: 767,
                settings: {
                    slidesToShow: <?=min(count($arResult['ITEMS']), 3)?>,
                }
            }
        ]
    });
</script>

