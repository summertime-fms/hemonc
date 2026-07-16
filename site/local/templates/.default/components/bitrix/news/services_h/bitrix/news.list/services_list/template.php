<?php

/*
* AlexBazowsky @github
* headachePro bot since aug 2023
*/

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);
?>

<div class="center-wrap ">
    <section class="hemonc2__list">
        <div class="center-wrap">
            <div class="hemonc2__list__grid">
                <?php foreach ($arResult['ITEMS'] as $service) { ?>
                    <a href="<?=$service['DETAIL_PAGE_URL']?>"
                        class="hemonc2__list__item">
                        <div class="hemonc2__list__name">
                            <?=$service['NAME']?>
                        </div>
                        <div class="hemonc2__list__price">
                            <?=$service['PROPERTIES']['LABEL']['VALUE']?>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </section>
</div>
