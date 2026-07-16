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

<div class="publications-list-block">
    <div class="wrapper">
        <div class="publications-list-container">
            <?php foreach($arResult["rsSections"] as $arSection) { ?>
                <?php if (!empty($arSection["CODE"])) { ?>
                    <a href="/about-us/publications/<?=$arSection['CODE']?>/" class="publications-list-item" title="<?=$arSection["NAME"]?>">
                        <span><?=$arSection["NAME"]?></span>
                    </a>
                <?php } else { ?>
                    <a class="publications-list-item-dis" title="<?=$arSection["NAME"]?>">
                        <span><?=$arSection["NAME"]?></span>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>