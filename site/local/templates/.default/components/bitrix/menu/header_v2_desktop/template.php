<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$this->setFrameMode(true);

if (!empty($arResult)) {
    echo '<div class="header__subrow" itemscope itemtype="http://schema.org/SiteNavigationElement">';

    $previousLevel = 0;

    foreach ($arResult as $arItem) {
        if ($arItem["DEPTH_LEVEL"] < $previousLevel) {
            echo '</div></div></div>';
        }

        if ($arItem["IS_PARENT"]) {
            if ($arItem["DEPTH_LEVEL"] == 1) { ?>
                <div class="header__subitem --toggle">
                    <a href="<?=$arItem["LINK"]?>"
                        class="header__sublink --toggler <?=$arItem["SELECTED"] ? 'item-selected' : 'item'?>"
                        ><?=$arItem["TEXT"]?></a>
            <?php }
        } else {
            if ($arItem["DEPTH_LEVEL"] == 1) { ?>
                <div class="header__subitem <?=$arItem["SELECTED"] ? 'item-selected' : 'item'?>">
                    <a
                        itemprop="url"
                        href="<?=$arItem["LINK"]?>"
                        class="header__sublink <?=$arItem["SELECTED"] ? 'item-selected' : 'item'?>"
                        ><?=$arItem["TEXT"]?></a>
                </div>
            <?php } else {
                if ($arItem["DEPTH_LEVEL"] > $previousLevel) { ?>
                    <div class="header__second-menu">
                        <div class="header__second-list">
                <?php } ?>
                <a
                    itemprop="url"
                    href="<?=$arItem["LINK"]?>"
                    class="header__second-link <?=$arItem["SELECTED"] ? 'item-selected' : 'item'?>"
                    ><?=$arItem["TEXT"]?></a>
            <?php }
        }

        $previousLevel = $arItem["DEPTH_LEVEL"];
    }

    if ($previousLevel > 1) {
        echo str_repeat("</div></div></div>", ($previousLevel - 1));
    }

    echo '</div>';
}
