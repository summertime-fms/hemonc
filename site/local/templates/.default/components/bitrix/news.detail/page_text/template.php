<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

$this->setFrameMode(true);

if (isset($arParams['HEADER_TEXT_CONTAINER'])) {
    $this->SetViewTarget($arParams['HEADER_TEXT_CONTAINER']);
}
    if($arResult["DETAIL_TEXT"] <> '') {?>
        <?=$arResult["DETAIL_TEXT"]?>
    <?php }

if (isset($arParams['HEADER_TEXT_CONTAINER'])) {
    $this->EndViewTarget();
}