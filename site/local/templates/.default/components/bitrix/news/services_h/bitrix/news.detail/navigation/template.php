<?php

/*
* AlexBazowsky @github
* headachePro bot since aug 2023
*/

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);
?>

<div class="center-wrap ">
    <div class="hemonc2__navigation">
        <?php if (!empty($arResult['PROPERTIES']['PRICE_GRID']['VALUE'])) { ?>
            <a href="#prices" class="hemonc2__navigation-link">цены</a>
        <?php } ?>

        <a href="#service" class="hemonc2__navigation-link">об&nbsp;услуге</a>
        
        <a href="#doctors" class="hemonc2__navigation-link">врачи</a>

        <?php if ($arResult['GALLERY']) { ?>
            <a href="#gallery" class="hemonc2__navigation-link">в&nbsp;клинике</a>
        <?php } ?>

        <a href="#reviews" class="hemonc2__navigation-link">отзывы</a>

        <?php if ($arResult['PROPERTIES']['FAQ_BOTTOM']['~VALUE'] && count($arResult['PROPERTIES']['FAQ_BOTTOM']['VALUE'])) { ?>
            <a href="#faq" class="hemonc2__navigation-link">вопросы&nbsp;и&nbsp;ответы</a>
        <?php } ?>
    </div>
</div>

<script>
    $(document).on('click', '.hemonc2__navigation-link', function(event) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top - 150
        }, 500);
    });
</script>
