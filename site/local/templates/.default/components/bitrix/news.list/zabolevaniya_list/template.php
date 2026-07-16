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
<div class="wrapper">
    <div class="services-block" style="margin-bottom: 3rem;">
        <div class="wrapper">
            <div class="grid-row-root grid-row grid-row-flex cols-b3 cols-m3 zabolevaniya-container">
                <?php foreach ($arResult["SECTIONS"] as $arSection) { ?>
                    <div class="grid-col bgdefault">
                        <div class="service-info-block">
                        <span class="title"><?=$arSection['NAME']?></span>
                            <div class="pseudo-table">
                                <?php foreach ($arSection['ITEMS'] as $arItem) { ?>
                                    <p class="pseudo-table-row">
                                        <span id="<?=$arItem['ID']?>" class="pseudo-table-col">
                                            <?php if (!empty($arItem['DETAIL_TEXT'])) { ?>
                                                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
                                            <?php } else { ?>
                                                <a class="curs-def"><?=$arItem["NAME"]?></a>
                                            <?php } ?>
                                            <small><?=$arItem['PREVIEW_TEXT']?></small>
                                        </span>
                                        <span class="pseudo-table-col">
                                        </span>
                                    </p>
                                <?php } ?>
                            </div>
                            <?php foreach ($arSection['SECTIONS'] as $arSubsection) { ?>
                                <span class="title">
                                    <?=$arSubsection['NAME']?>
                                </span>
                                <div class="pseudo-table">
                                    <?php foreach ($arSubsection['ITEMS'] as $arItem) { ?>
                                        <p class="pseudo-table-row">
                                            <span id="<?=$arItem['ID']?>" class="pseudo-table-col">
                                                <?php if (!empty($arItem['DETAIL_TEXT'])) { ?>
                                                    <a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
                                                <?php } else { ?>
                                                    <a class="curs-def"><?=$arItem["NAME"]?></a>
                                                <?php } ?>
                                                <small><?=$arItem['PROPERTIES']['LABEL']['VALUE']?></small>
                                            </span>
                                            <span class="pseudo-table-col">
                                                <?=$arItem['PROPERTIES']['PRICE']['VALUE']?>
                                            </span>
                                        </p>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
