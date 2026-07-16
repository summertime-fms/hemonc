<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2023
 */

$cp = $this->__component;

$arResult['chainElement'] = $arResult["PROPERTIES"]["FIRST_NAME"]["VALUE"] . ' ' . $arResult["PROPERTIES"]["MID_NAME"]["VALUE"] . ' ' .$arResult["NAME"];

if (is_object($cp)) {
    $cp->SetResultCacheKeys([
        'chainElement',
    ]);
}

$arResult['schedule'] = false;

if (
    isset($arResult["PROPERTIES"]["ONES_GUID"]["VALUE"])
    && !empty($arResult["PROPERTIES"]["ONES_GUID"]["VALUE"])
) {
    if (array_key_exists($arResult["PROPERTIES"]["ONES_GUID"]["VALUE"], $arParams['nearestTimeWeekAll'])) {
        $arResult['schedule'] = $arParams['nearestTimeWeekAll'][$arResult["PROPERTIES"]["ONES_GUID"]["VALUE"]];
    }
}
