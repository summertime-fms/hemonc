<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2024
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}
?>

<section class="blog-themes-list-block bgdefault title-link-block">
    <div class="title">
        <a href="/about-us/blog/">Мы в СМИ</a>
    </div>
    <div class="blog-themes-list-content">
        <?php foreach ($arResult["ITEMS"] as $arItem) { ?>
            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>">
                <span><?=$arItem["NAME"]?></span>
                <time datetime="<?=$arItem["DISPLAY_ACTIVE_FROM"]?>"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></time>
            </a>
        <?php }?>
    </div>
</section>