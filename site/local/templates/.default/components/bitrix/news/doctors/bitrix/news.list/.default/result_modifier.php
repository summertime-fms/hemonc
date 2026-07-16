<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

foreach($arResult["ITEMS"] as &$arItem) {
    if (!isset($arItem["PREVIEW_PICTURE"]["SRC"]) || empty($arItem["PREVIEW_PICTURE"]["SRC"])) {
        $arItem["PREVIEW_PICTURE"]["SRC"] = SITE_TEMPLATE_PATH . '/images/photo-default.png';    
    }

    $arItem['schedule'] = false;

    if (
        isset($arItem["PROPERTIES"]["ONES_GUID"]["VALUE"])
        && !empty($arItem["PROPERTIES"]["ONES_GUID"]["VALUE"])
    ) {
        if (array_key_exists($arItem["PROPERTIES"]["ONES_GUID"]["VALUE"], $arParams['nearestTimeWeekAll'])) {
            $arItem['schedule'] = $arParams['nearestTimeWeekAll'][$arItem["PROPERTIES"]["ONES_GUID"]["VALUE"]];
        }
    }
}
