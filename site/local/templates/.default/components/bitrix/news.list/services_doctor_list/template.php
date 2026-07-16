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

<?php foreach ($arResult["SECTIONS"] as $arSection) { ?>
    <div class="doctor-services-price-item">
        <a href="/services/<?=$arSection['CODE']?>/" class="service-head-link">
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
        <div class="service-info-block">
            <div class="text-column col-m2">
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
</section>