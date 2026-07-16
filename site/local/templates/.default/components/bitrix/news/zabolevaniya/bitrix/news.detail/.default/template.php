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

<div class="default-main-block-content">
    <div class="grid-row-root grid-row grid-row-flex cols-b2 cols-m1">
        <div class="grid-col bgdefault text-block">
        <?php if ($arResult['PREVIEW_PICTURE']['SRC']) { ?>
                <p>
                    <img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']?>"/>
                </p>
            <?php } ?>

            <?=$arResult['DETAIL_TEXT']?>
            

            <div class="inline-container">
            <?php $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                [
                    "PATH"           => SITE_TEMPLATE_PATH . "/parts/bitrixCallback.php",
                    "AREA_FILE_SHOW" => "file",
                ],
            ); ?>
            </div>
        </div>

    </div>
</div>
</div>
