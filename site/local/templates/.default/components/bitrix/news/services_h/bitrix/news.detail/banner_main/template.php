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

<?php if ($arResult['BANNER_TITLE'] || $arResult['BANNER_SUBTITLE']):?>
    <div class="center-wrap ">
        <div class="hemonc2__head">
            <?php if ($arResult['PROPERTIES']['BANNER_PICTURE']['SRC']):?>
                <img src="<?=$arResult['PROPERTIES']['BANNER_PICTURE']['SRC']?>"
                    alt="">
            <?php endif; ?>

            <?php if ($arParams['SHOW_BANNER_TITLE'] != 'N'):?>
                <div class="hemonc2__head-title <?=$arResult['PROPERTIES']['BANNER_TITLE_COLOR']['VALUE_XML_ID'] ?: ''?>">
                    <?=$arResult['BANNER_TITLE']?>
                </div>
            <?php endif; ?>

            <?php if ($arParams['SHOW_BANNER_SUBTITLE'] == 'Y'):?>
                <div class="hemonc2__head__subtitle <?=$arResult['PROPERTIES']['BANNER_TITLE_COLOR']['VALUE_XML_ID'] ?: ''?>">
                    <?=$arResult['BANNER_TITLE']?>
                </div>
            <?php endif; ?>

            <?php if (
                $arResult['BANNER_SUBTITLE']
                || $arResult['PROPERTIES']['BANNER_BUTTON_TEXT']['VALUE']
            ):?>
                <div class="hemonc2__head__desc <?=$arResult['PROPERTIES']['BANNER_SUBTITLE_COLOR']['VALUE_XML_ID'] ?: ''?>">
                    <?=$arResult['PROPERTIES']['BANNER_SUBTITLE']['VALUE']?>

                    <?php if ($arResult['PROPERTIES']['BANNER_BUTTON_TEXT']['VALUE']) { ?>
                        <?php if ($arResult['PROPERTIES']['BANNER_BUTTON_LINK']['VALUE']) { ?>
                            <a href="<?=$arResult['PROPERTIES']['BANNER_BUTTON_LINK']['VALUE']?>" class="hemonc2__head__button btn">
                                <?=$arResult['PROPERTIES']['BANNER_BUTTON_TEXT']['VALUE']?>
                            </a>
                        <?} else { ?>
                            <a href="#" class="hemonc2__head__button btn" onclick="SelectDoctorPopup()">
                                <?=$arResult['PROPERTIES']['BANNER_BUTTON_TEXT']['VALUE']?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
