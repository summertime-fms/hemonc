<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}
$this->createFrame()->begin("Загрузка навигации");

if ($arResult["NavPageCount"] > 1) {
    if ($arResult["NavPageNomer"] + 1 <= $arResult["nEndPage"]) {
        $plus = $arResult["NavPageNomer"] + 1;
        $url  = $arResult["sUrlPathParams"] . "PAGEN_" . $arResult["NavNum"] . "=" . $plus;
        ?>
        <a class="button-blue load_more" id="more-rev-mobile" data-url="<?=$url?>" onclick="pagerLoadMore();" style="width: 100%; margin: 5rem auto;">Загрузить еще</a>
	<?php } else { ?>
        <a class="button-blue load_more" id="more-rev-mobile" style="width: 100%; margin: 5rem auto;">Загружено все</a>
	<?php }
}
