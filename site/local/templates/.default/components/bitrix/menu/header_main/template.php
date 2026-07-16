<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$this->setFrameMode(true);

if (!empty($arResult)) {
    foreach ($arResult as $arItem) {
        if ($arItem["DEPTH_LEVEL"] == 1) { ?>
            <a itemprop="url" href="<?=$arItem["LINK"]?>" class="<?=$arItem["SELECTED"] ? 'active' : ''?>">
                <?=$arItem["TEXT"]?>
            </a>
        <?php }
    }
}


