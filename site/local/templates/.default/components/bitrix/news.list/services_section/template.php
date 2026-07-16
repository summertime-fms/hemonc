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

<!-- <div class="wrapper"> -->
    <div class="services-columns-block">
        <div class="wrapper">
            <div class="gray-block bgdefault">
                <div class="service-info-block">
                    <div class="text-column col-b3 col-m2">
                        <?php foreach ($arResult["SECTIONS"] as $arSection) {
                            if (
                                !$arSection['ITEMS']
                                || count($arSection['ITEMS']) == 0
                            ) {
                                continue;
                            } ?>
                            <div class="no-break">
                                <span class="title"><?=$arSection['NAME']?></span>
                                <div class="pseudo-table">
                                    <?php foreach ($arSection['ITEMS'] as $arItem) { ?> 
                                        <?php if(in_array($arItem['CODE'], $skipCodes)) { continue; } ?>
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
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- </div> -->
