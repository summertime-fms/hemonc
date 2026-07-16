<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);

if (empty($arResult["ITEMS"])) {
    return;
}

usort($arResult["ITEMS"], function ($a, $b) {
    $dateA = strtotime($a["PROPERTIES"]["REVIEW_DATE"]["VALUE"] ?? '');
    $dateB = strtotime($b["PROPERTIES"]["REVIEW_DATE"]["VALUE"] ?? '');
    return $dateB - $dateA;
});


$reviewsCount = count($arResult["ITEMS"]);
$mobileArrows = $reviewsCount > 1 ? 'true' : 'false';
$desktopArrows = $reviewsCount >= 4 ? 'true' : 'false';
$desktopSlides = min(3, $reviewsCount);
?>
<section class="title-block doctor-reviews-block">
    <div class="wrapper">
        <h2 class="title">Отзывы о враче (<?=$reviewsCount?>)</h2>
        <div class="doctor-reviews-slider-wrap">
            <div class="doctor-reviews-slider swiper" data-mobile-arrows="<?=$mobileArrows?>" data-desktop-arrows="<?=$desktopArrows?>">
                <div class="swiper-wrapper">
                    <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
                        <div class="swiper-slide">
                            <article class="doctor-reviews-item bgdefault">
                                <div class="doctor-reviews-item__head">
                                    <?php if (!empty($arItem["PREVIEW_PICTURE"]["SRC"])) { ?>
                                        <span class="doctor-reviews-item__img">
                                            <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>">
                                        </span>
                                    <?php } ?>
                                    <?php $reviewExternalUrl = (string)($arItem["PROPERTIES"]["TITLE"]["VALUE"] ?? ''); ?>
                                    <?php if ($reviewExternalUrl !== '') { ?>
                                        <a
                                            class="doctor-reviews-item__name"
                                            href="<?=htmlspecialcharsbx($reviewExternalUrl)?>"
                                            target="_blank"
                                            rel="noopener noreferrer nofollow"
                                        ><?=$arItem["NAME"]?></a>
                                    <?php } else { ?>
                                        <span class="doctor-reviews-item__name"><?=$arItem["NAME"]?></span>
                                    <?php } ?>
                                </div>
                                <div class="doctor-reviews-item__text">
                                    <?=!empty($arItem["PREVIEW_TEXT"]) ? $arItem["PREVIEW_TEXT"] : $arItem["DETAIL_TEXT"]?>
                                </div>
                            </article>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <button type="button" class="doctor-reviews-slider__arrow doctor-reviews-slider__arrow--prev" aria-label="Предыдущий отзыв">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <use href="<?=SITE_TEMPLATE_PATH.'/images/sprite.svg#slide-arrow'?>" xlink:href="<?=SITE_TEMPLATE_PATH.'/images/sprite.svg#slide-arrow'?>"></use>
                </svg>
            </button>
            <button type="button" class="doctor-reviews-slider__arrow doctor-reviews-slider__arrow--next" aria-label="Следующий отзыв">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <use href="<?=SITE_TEMPLATE_PATH.'/images/sprite.svg#slide-arrow'?>" xlink:href="<?=SITE_TEMPLATE_PATH.'/images/sprite.svg#slide-arrow'?>"></use>
                </svg>
            </button>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
<script>
    (function () {
        if (typeof window.Swiper === 'undefined') {
            return;
        }

        var $slider = window.jQuery ? window.jQuery('.doctor-reviews-slider') : null;
        if (!$slider || !$slider.length) {
            return;
        }

        var sliderEl = $slider.get(0);
        if (sliderEl && sliderEl.dataset.swiperInitialized === '1') {
            return;
        }
        if (sliderEl) {
            sliderEl.dataset.swiperInitialized = '1';
        }

        var mobileArrows = $slider.data('mobile-arrows') === true || $slider.data('mobile-arrows') === 'true';
        var desktopArrows = $slider.data('desktop-arrows') === true || $slider.data('desktop-arrows') === 'true';

        var $wrap = $slider.closest('.doctor-reviews-slider-wrap');
        var $prevArrow = $wrap.find('.doctor-reviews-slider__arrow--prev');
        var $nextArrow = $wrap.find('.doctor-reviews-slider__arrow--next');

        var prevEl = $prevArrow.get(0);
        var nextEl = $nextArrow.get(0);

        var swiper = new window.Swiper(sliderEl, {
            loop: false,
            slidesPerView: 1,
            spaceBetween: 0,
            autoHeight: false,
            watchOverflow: true,
            grabCursor: false,
            navigation: {
                prevEl: prevEl,
                nextEl: nextEl
            },
            breakpoints: {
                768: {
                    slidesPerView: <?=$desktopSlides?>,
                }
            }
        });

        function toggleArrows() {
            var isMobile = window.innerWidth <= 767;
            var enabled = isMobile ? mobileArrows : desktopArrows;
            if (prevEl) prevEl.style.display = enabled ? 'grid' : 'none';
            if (nextEl) nextEl.style.display = enabled ? 'grid' : 'none';
        }

        toggleArrows();

        window.addEventListener('resize', function () {
            toggleArrows();
        });
    })();
</script>

<style>
    .doctor-reviews-block {
        margin-bottom: 32px;
    }

    .doctor-reviews-block .title {
        margin-bottom: 24px;
    }

    .doctor-reviews-slider-wrap {
        position: relative;
    }

    .doctor-reviews-slider {
        margin: 0 -8px;
        position: relative;
    }

    .doctor-reviews-slider .swiper-slide {
        height: auto;
    }

    .doctor-reviews-item {
        margin: 0 8px;
        padding: 24px 20px;
        height: 320px;
        display: flex;
        flex-direction: column;
    }

    .doctor-reviews-item__head {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    .doctor-reviews-item__img {
        flex: 0 0 48px;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        overflow: hidden;
    }

    .doctor-reviews-item__img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .doctor-reviews-item__name {
        font-weight: 700;
        color: inherit;
        text-decoration: none;
        transition: color 0.15s ease, opacity 0.15s ease;
    }

    .doctor-reviews-item__name:hover {
        color: var(--pink, #F6AE9C);
    }

    .doctor-reviews-item__name:focus-visible {
        outline: 2px solid var(--green, #007088);
        outline-offset: 2px;
    }

    .doctor-reviews-item__text {
        line-height: 1.45;
        overflow-y: auto;
        flex: 1 1 auto;
        min-height: 0;
        padding-right: 8px;
        scrollbar-width: thin;
    }

    .doctor-reviews-item__text::-webkit-scrollbar {
        width: 6px;
    }

    .doctor-reviews-item__text::-webkit-scrollbar-thumb {
        background: #c6ccd4;
        border-radius: 999px;
    }

    .doctor-reviews-item__text::-webkit-scrollbar-track {
        background: #eef1f4;
        border-radius: 999px;
    }

    .doctor-reviews-slider__arrow {
        position: absolute;
        display: grid;
        place-items: center;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1;
        width: 36px;
        height: 36px;
        border: 1px solid var(--green, #007088);
        border-radius: 50%;
        background-color: #fff;
        color: var(--green, #007088);
        cursor: pointer;
        transition: color 0.1s ease, border-color 0.1s ease;
    }

    .doctor-reviews-slider__arrow:disabled {
        cursor: not-allowed;
        pointer-events: none;
        filter: grayscale(100%);
    }

    .doctor-reviews-slider__arrow svg {
        transform: scale(0.65);
    }

    .doctor-reviews-slider__arrow:hover  {
        color: var(--pink, #F6AE9C);
        border-color: var(--pink, #F6AE9C);
    }

    .doctor-reviews-slider__arrow--prev {
        left: -30px !important;
        transform: rotate(180deg) translateY(50%);
    }

    .doctor-reviews-slider__arrow--next {
        right: -30px !important;
    }

    .doctor-reviews-item {
        height: 280px;
    }

    @media (max-width: 767px) {
        .doctor-reviews-item {
            height: 370px;
        }

        .doctor-reviews-block {
            margin-bottom: 24px;
        }
    }
</style>
