<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2023
 */

if ($arParams['DISPLAY_PREVIEW_TEXT'] != 'N') {
    $APPLICATION->AddViewContent("header-content", $arResult['curSect_DESCRIPTION']);
}
