<?php

/*
* AlexBazowsky @github
* for Headache since aug 2024
*/

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}
?>

<div class="center-wrap">
    <div class="hemonc2__doctors slick-slider" id="doctors">
        <div class="hemonc2__row">
            <div class="hemonc2__h2">Врачи</div>
            <a href="#" class="hemonc2__link">смотреть все</a>
        </div>
        <div class="hemonc2__doctors__swiper">
            <?php foreach ($arResult['ITEMS'] as $arItem) { ?>
                <div class="hemonc2__doctors-item">
                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="hemonc2__doctors__wrap">
                        <img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arItem["NAME"]?>">
                    </a>
                    <div class="hemonc2__doctors__body">
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="hemonc2__doctors__name"><?=$arItem["NAME"]?><br><?=$arItem["PROPERTIES"]["FIRST_NAME"]["VALUE"]?> <?=$arItem["PROPERTIES"]["MID_NAME"]["VALUE"]?></a>
                        <div class="hemonc2__doctors__pos"><?=$arItem["PROPERTIES"]["TITLE"]["VALUE"]?></div>
                        <div class="hemonc2__doctors__link" onclick="ShowPersonalDoctorPopup(<?=$arItem['ID']?>);">Записаться</div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</div>

<script>
    $('.hemonc2__doctors__swiper').slick({
        adaptiveHeight: true, 
        mobileFirst: true,
        infinite: false,
        dots: true,
        dotsClass: 'hemonc2__doctors-dots',
        appendDots: '.hemonc2__doctors',
        arrows: false,
        slidesToShow: <?=min(count($arResult['ITEMS']), 2 )?>,
        swipeToSlide: true,
        // centerMode: true,
        // variableWidth: true,
        responsive: [
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: <?=min(count($arResult['ITEMS']), 3)?>,
                }
            },{
                breakpoint: 767,
                settings: {
                    slidesToShow: <?=min(count($arResult['ITEMS']), 4)?>,
                }
            },{
                breakpoint: 1199,
                settings: {
                    slidesToShow: <?=min(count($arResult['ITEMS']), 5)?>,
                }
            }
        ]
    });
</script>