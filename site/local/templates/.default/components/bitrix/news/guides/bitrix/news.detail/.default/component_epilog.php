<?php

if (isset($arParams['CSS_CLASS_BODY'])) {
    $APPLICATION->AddViewContent('body-class', $arParams['CSS_CLASS_BODY']);
}

if (isset($arParams['CSS_CLASS_HEADER'])) {
    $APPLICATION->AddViewContent('header-class', $arParams['CSS_CLASS_HEADER']);
}
