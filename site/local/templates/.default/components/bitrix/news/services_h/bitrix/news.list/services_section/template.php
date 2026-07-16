<?php

/*
* AlexBazowsky @github
* headachePro bot since aug 2023
*/

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);
?>

<section class="hemonc2__price">
    <div class="center-wrap">
        <div class="hemonc2__price__grid">
            <?php if (!empty($arResult["SECTIONS"])): ?>
                <?php foreach ($arResult["SECTIONS"] as $arSection) {
                    if (
                        !$arSection['ITEMS']
                        || count($arSection['ITEMS']) == 0
                    ) {
                        continue;
                    } ?>
                    <div class="hemonc2__price__item">
                        <div class="hemonc2__price__top">
                            <?=$arSection['NAME']?>
                        </div>
                        <div class="hemonc2__price__body">
                            <?php foreach ($arSection["ITEMS"] as $arItem) { ?>
                                <div class="hemonc2__price__subitem">
                                    <div class="hemonc2__price__block">
<!--                                        --><?php //if (!empty($arItem['DETAIL_TEXT'])) { ?>
                                            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="hemonc2__price__name"><?=$arItem["NAME"]?></a>
<!--                                        --><?php //} else { ?>
<!--                                            <span class="hemonc2__price__name dark">--><?php //=$arItem["NAME"]?><!--</span>-->
<!--                                        --><?php //} ?>

                                        <?php if (!empty($arItem['PROPERTIES']['LABEL']['VALUE'])): ?>
                                            <div class="hemonc2__price__desc">
                                                <?=$arItem['PROPERTIES']['LABEL']['VALUE']?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($arItem['PROPERTIES']['PRICE']['VALUE'])): ?>
                                        <div class="hemonc2__price__price">
                                            <?= $arItem['PROPERTIES']['PRICE']['VALUE']?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php endif; ?>
        </div>
    </div>
</section>
