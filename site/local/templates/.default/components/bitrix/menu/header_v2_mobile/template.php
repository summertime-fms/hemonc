<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$this->setFrameMode(true);

if (!empty($arResult)) {
    echo '<div class="header__mobile-menu" itemscope itemtype="http://schema.org/SiteNavigationElement">';

    $previousLevel = 0;

    foreach ($arResult as $arItem) {
        if ($arItem["DEPTH_LEVEL"] < $previousLevel) {
            echo '</div></div>';
        }

        if ($arItem["IS_PARENT"]) {
            if ($arItem["DEPTH_LEVEL"] == 1) { ?>
                <div class="header__mobile-item">
                    <div class="header__mobile-row <?=$arItem["SELECTED"] ? 'item-selected' : 'item'?>">
                        <div class="header__mobile-link header__mobile-toggler-text"><?=$arItem["TEXT"]?></div>
                        <div class="header__mobile-toggler"></div>
                    </div>
            <?php }
        } else {
            if ($arItem["DEPTH_LEVEL"] == 1) { ?>
                <div class="header__mobile-item <?=$arItem["SELECTED"] ? 'item-selected' : 'item'?>">
                    <div class="header__mobile-row">
                    <a
                        itemprop="url"
                        href="<?=$arItem["LINK"]?>"
                        class="header__mobile-link <?=$arItem["SELECTED"] ? 'item-selected' : 'item'?>"
                        ><?=$arItem["TEXT"]?></a>
                    </div>
                </div>
            <?php } else {
                if ($arItem["DEPTH_LEVEL"] > $previousLevel) { ?>
                    <div class="header__mobile-sub">
                <?php } ?>
                <a
                    itemprop="url"
                    href="<?=$arItem["LINK"]?>"
                    class="header__mobile-sublink <?=$arItem["SELECTED"] ? 'item-selected' : 'item'?>"
                    ><?=$arItem["TEXT"]?></a>
            <?php }
        }

        $previousLevel = $arItem["DEPTH_LEVEL"];
    }

    if ($previousLevel > 1) {
        echo str_repeat("</div></div>", ($previousLevel - 1));
    }

    echo '</div>';
}
