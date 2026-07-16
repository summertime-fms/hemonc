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
                    <h2>
                        <?=$arResult["NAME"]?>
                    </h2>
                    <time class="time" datetime="<?=FormatDate('Y-m-d', MakeTimeStamp($arResult["ACTIVE_FROM"]))?>"><?=$arResult["DISPLAY_ACTIVE_FROM"]?></time>
                    <?php if (isset($arResult["PREVIEW_PICTURE"]["SRC"]) && !empty($arResult["PREVIEW_PICTURE"]["SRC"])) { ?>
                        <span class="img">
                            <img src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" alt="">
                        </span>
                    <?php } ?>
                </header>

                <div class="text-block">
                    <?=!empty($arResult['DETAIL_TEXT']) ? $arResult['DETAIL_TEXT'] : $arResult['PREVIEW_TEXT']?>
                </div>

                <?php require __DIR__ . '/article_eeat_blocks.php'; ?>

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
                    <?php foreach ($arResult['OTHER_FEEDS'] as $otherFeed) {?>
                        <a href="<?=$otherFeed['DETAIL_PAGE_URL']?>" title="<?=$otherFeed['NAME']?>">
                            <span class="span"><?=$otherFeed['NAME']?></span><span class="time"><?=$otherFeed["DISPLAY_ACTIVE_FROM"]?></span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
