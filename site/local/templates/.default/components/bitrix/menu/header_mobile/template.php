<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

$this->setFrameMode(true);

if (!empty($arResult)) {
    echo '<ul>';
    foreach ($arResult as $arItem) {
        if ($arItem["DEPTH_LEVEL"] == 1) { ?>
            <li>
                <a href="<?=$arItem["LINK"]?>"
                    class="<?=$arItem["SELECTED"] ? 'active' : ' '?>"
                    <?=isset($arItem['PARAMS']['onclick']) ? 'onclick="' . $arItem['PARAMS']['onclick'] . '"' : ''?>
                    <?=isset($arItem['PARAMS']['target']) ? 'target="' . $arItem['PARAMS']['target'] . '" rel="noopener nofollow"' : ''?>
                    <?=isset($arItem['PARAMS']['rel']) ? 'rel="' . $arItem['PARAMS']['rel'] . '"' : ''?>
                    ><?=$arItem["TEXT"]?><?=$arItem['PARAMS']['span'] ?? ''?></a>
            </li>
        <?php }
    }
    echo '</ul>';
}
