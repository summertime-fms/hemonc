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

<div class="blog-main-container">
    <div class="wrapper">
        <div class="grid-row-root grid-row-flex grid-row cols-b2 col-m1">
            <section class="grid-col blog-main-content bgdefault">
                <header>
                    <h2><a href="<?=$arResult["ITEMS"][0]["DETAIL_PAGE_URL"]?>"><?=$arResult["ITEMS"][0]["NAME"]?></a></h2>
                        <time datetime="<?=$arResult["ITEMS"][0]["DISPLAY_ACTIVE_FROM"]?>"><?=$arResult["ITEMS"][0]["DISPLAY_ACTIVE_FROM"]?></time>
                        <?php if (is_array($arResult["ITEMS"][0]["PREVIEW_PICTURE"])) { ?>
                            <a href="<?=$arResult["ITEMS"][0]["DETAIL_PAGE_URL"]?>" class="img">
                                <img src="<?=$arResult["ITEMS"][0]["PREVIEW_PICTURE"]['SRC']?>" />
                            </a>
                        <?php }?>
                </header>
                <div class="text-block">
                    <?=!empty($arResult["ITEMS"][0]["PREVIEW_TEXT"]) ? $arResult["ITEMS"][0]["PREVIEW_TEXT"] : $arResult["ITEMS"][0]["DETAIL_TEXT"]?>
                </div>
                <?php unset($arResult["ITEMS"][0]);?>

                <?php $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    [
                        "PATH"           => SITE_TEMPLATE_PATH . "/parts/reviews.php",
                        "AREA_FILE_SHOW" => "file",
                    ],
                )?>

                <?php $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    [
                        "PATH"           => SITE_TEMPLATE_PATH . "/parts/bitrixCallback.php",
                        "AREA_FILE_SHOW" => "file",
                    ],
                )?>
            </section>

            <div class="grid-col blog-themes-list-block bgdefault">
                <div class="blog-themes-list-content">
                    <?foreach($arResult["ITEMS"] as $arItem):?>
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" title="<?=$arItem["NAME"]?>">
                            <span><?=$arItem["NAME"]?></span><time><?=$arItem["DISPLAY_ACTIVE_FROM"]?></time>
                        </a>
                    <?endforeach;?>

                    <?php if ($arParams["DISPLAY_BOTTOM_PAGER"]):?>
                        <?=$arResult["NAV_STRING"]?>
                    <?php endif;?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
