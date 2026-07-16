<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2024
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}
?>
<div class="t-h2">
    <a href="/about-us/blog/">Мы в СМИ</a>
</div>
<?php if (isset($arResult["ITEMS"][0])) { ?>
    <h3>
        <a href="<?=$arResult["ITEMS"][0]["DETAIL_PAGE_URL"]?>"><?=$arResult["ITEMS"][0]["NAME"]?></a>
    </h3>
    <time datetime="<?=$arResult["ITEMS"][0]["DISPLAY_ACTIVE_FROM"]?>">
        <?=$arResult["ITEMS"][0]["DISPLAY_ACTIVE_FROM"]?>
    </time>
    <p>
        <?=!empty($arResult["ITEMS"][0]["PREVIEW_TEXT"]) ? $arResult["ITEMS"][0]["PREVIEW_TEXT"] : $arResult["ITEMS"][0]["DETAIL_TEXT"]?>
        <a href="<?=$arResult["ITEMS"][0]["DETAIL_PAGE_URL"]?>">читать полностью</a>
    </p>
<?php } ?>
<?php unset($arResult["ITEMS"][0]);?>
<aside>
    <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                <?=$arItem["NAME"]?>
                <time datetime="<?=$arItem["DISPLAY_ACTIVE_FROM"]?>"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></time>
            </a>
    <?php }?>
</aside>