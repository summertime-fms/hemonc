<?php

/*
* AlexBazowsky @github
* headachePro bot since aug 2023
*/

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(false);

if (mb_stripos($APPLICATION->GetCurPage(false), '/diagnostics/')) {
    $arResult['currentTab'] = 'diagnostics';
} elseif (mb_stripos($APPLICATION->GetCurPage(false), '/treatment/')) {
    $arResult['currentTab'] = 'treatment';
} else {
    $arResult['currentTab'] = 'disease';
}

?>
<div class="publication-block-nav">
    <?php foreach($arResult["ITEMS"] as $arItem) { ?>
        <a 
            href="<?=$arItem["DETAIL_PAGE_URL"]?>"
            <?=($arResult["currentTab"] == $arItem['CODE']) ? 'class="active"' : ''?>
            >
            <?=$arItem["PREVIEW_TEXT"]?>
        </a>
    <?php } ?>
</div>