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

<?php foreach ($arResult["ITEMS"] as $arSection) { ?>
    <h2 class="video-chart-title"><?=$arSection['NAME']?></h2>
    <div class="videos-container">
        <?php foreach ($arSection['ELEMENTS'] as $arItem) { ?>
            <?php if ($arItem['PROPERTIES']['YOUTUBE_ID']['VALUE']) { ?>
                <div class="video-card">
                    <div class="yt-video">
                        <a class="yt-video__link" href="https://youtu.be/<?=$arItem['PROPERTIES']['YOUTUBE_ID']['VALUE']?>">
                            <picture>
                                <source srcset="https://i.ytimg.com/vi_webp/<?=$arItem['PROPERTIES']['YOUTUBE_ID']['VALUE']?>/maxresdefault.webp" type="image/webp">
                                <img class="yt-video__media" src="https://i.ytimg.com/<?=$arItem['PROPERTIES']['YOUTUBE_ID']['VALUE']?>/maxresdefault.jpg" data-media="<?=$arItem['PROPERTIES']['YOUTUBE_ID']['VALUE']?>" alt="<?=$arItem['NAME']?>">
                            </picture>
                        </a>
                        <button class="yt-video__button" aria-label="Запустить видео">
                            <svg width="68" height="48" viewBox="0 0 68 48"><path class="yt-video__button-shape" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"></path><path class="yt-video__button-icon" d="M 45,24 27,14 27,34"></path></svg>
                        </button>
                    </div>
                    <div class="video-card__title">
                        <?=$arItem['NAME']?>
                    </div>
                </div>
            <?php } else { ?>
                <div class="video-card">
                    <div class="video-card__container <?=(mb_stripos($arItem['DETAIL_TEXT'], 'youtube') ?: 'video-card__container--nonyt_')?>">
                        <?=$arItem['DETAIL_TEXT']?>
                    </div>
                    <div class="video-card__title">
                        <?=$arItem['NAME']?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
<?php } ?>
