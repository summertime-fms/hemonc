<?php

/*
* AlexBazowsky @github
* headachePro bot since aug 2023
*/

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);

$skipCodes = [
    'rak-golovy-i-shei',
    'rak-legkikh',
    'rak-sheiki-matki',
    'rak-iaichnikov',
    'limfoma',
    'rak-kishechnika',
    'rak-zheludka',
    'rak-podzheludochnoi-zhelezy',
    'lechenie-raka-mochevogo-puzyria',
    'lechenie-raka-matki',
    'rak-endometriia-tela-matki',
];
?>
<div class="wrapper">
    <div class="services-block" style="margin-bottom: 3rem;">
        <div class="wrapper">
            <div class="grid-row-root grid-row grid-row-flex cols-b3 cols-m3">
                <?php foreach ($arResult["SECTIONS"] as $arSection) { ?>
                    <div class="grid-col bgdefault">
                        <a href="<?=$arParams['IBLOCK_URL'] . $arSection['CODE']?>/" class="service-head-link">
                            <span>
                                <?php if ($arSection['CODE'] == 'consultation') { ?>
                                    <i class="svg-icon-serv-consult"></i>
                                    <i class="svg-icon-serv-consult-hover"></i>
                                <?php } elseif ($arSection['CODE'] == 'diagnostics') { ?>
                                    <i class="svg-icon-serv-diag"></i>
                                    <i class="svg-icon-serv-diag-hover"></i>
                                <?php } elseif ($arSection['CODE'] == 'treatment') { ?>
                                    <i class="svg-icon-serv-heal"></i>
                                    <i class="svg-icon-serv-heal-hover"></i>
                                <?php } ?>
                            </span>
                            <span><?=$arSection['NAME']?></span>
                        </a>
                        <div class="service-info-block for-big">
                            <div class="pseudo-table">
                                <?php foreach ($arSection['ITEMS'] as $arItem) { ?>
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
                            <?php foreach ($arSection['SECTIONS'] as $arSubsection) { ?>
                                <span class="title">
                                    <?=$arSubsection['NAME']?>
                                </span>
                                <div class="pseudo-table">
                                    <?php foreach ($arSubsection['ITEMS'] as $arItem) { ?>
                                        <?php if(in_array($arItem['CODE'], $skipCodes)) { continue; }?>
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
