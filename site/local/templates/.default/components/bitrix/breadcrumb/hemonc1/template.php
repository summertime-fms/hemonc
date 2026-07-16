<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    exit();
}

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

// delayed function must return a string
if (empty($arResult)) {
    return "";
}

$strReturn = '';

// we can't use $APPLICATION->SetAdditionalCSS() here because we are inside the buffered function GetNavChain()
$css = $APPLICATION->GetCSSArray();
if (!is_array($css) || !in_array("/bitrix/css/main/font-awesome.css", $css)) {
    $strReturn .= '<link href="' . CUtil::GetAdditionalFileURL("/bitrix/css/main/font-awesome.css") . '" type="text/css" rel="stylesheet" />' . "\n";
}

$strReturn .= '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
    <div class="center-wrap">
        <ul class="breadcrumbs__row">';

$itemSize = count($arResult);
for ($index = 0; $index < $itemSize; $index++) {
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);
    $link = $arResult[$index]["LINK"];
    $position = $index + 1;

    $strReturn .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';

    if ($link !== "" && $index != $itemSize - 1) {
        $strReturn .= '<a href="' . $link . '" class="breadcrumbs__link" itemprop="item" title="' . $title . '">
                          <span itemprop="name">' . $title . '</span>
                       </a>';
    } else {
        $strReturn .= '<span class="breadcrumbs__link" itemprop="name">' . $title . '</span>';
    }

    $strReturn .= '<meta itemprop="position" content="' . $position . '" />';
    $strReturn .= '</li>';
}

$strReturn .= '</ul>
    </div>
</div>';

return $strReturn;
