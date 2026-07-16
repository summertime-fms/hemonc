<?php

/*
* AlexBazowsky @github
* headachePro bot since aug 2023
*/

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$this->setFrameMode(true);

if ($arResult["NavRecordCount"] == 0 || $arResult["NavPageCount"] == 1) {
    return;
}
?>
<div class="pager">
    <?php
    $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
    $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

    // ob_start();

    if ($arResult["NavPageNomer"] > 1) {
        if ($arResult["nStartPage"] > 1) {
            if ($arResult["bSavePage"]) { ?>
                <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">
                    <div class="pager-page">1</div>
                </a>
            <?php } else { ?>
                <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
                    <div class="pager-page">1</div>
                </a>
            <?php }

            if ($arResult["nStartPage"] > 2) { ?>
                <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nStartPage"] / 2)?>">
                    <div class="pager-page">...</div>
                </a>
            <?php }
        }
    }

    do {
        if ($arResult["nStartPage"] == $arResult["NavPageNomer"]) { ?>
            <div class="pager-current-page">
                <?=$arResult["nStartPage"]?>
            </div>
        <?php } elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false) { ?>
            <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
                <div class="pager-page">
                    <?=$arResult["nStartPage"]?>
                </div>
            </a>
        <?php } else { ?>
            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>">
                <div class="pager-page">
                    <?=$arResult["nStartPage"]?>
                </div>
            </a>
        <?php }
        $arResult["nStartPage"]++;
    }
    while ($arResult["nStartPage"] <= $arResult["nEndPage"]);

    if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]) {
        if ($arResult["nEndPage"] < $arResult["NavPageCount"]) {
            if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)) { ?>
                <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)?>">
                    <div class="pager-page">
                        ...
                    </div>
                </a>
            <?php } ?>
            <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">
                <div class="pager-page">
                    <?=$arResult["NavPageCount"]?>
                </div>
            </a>
        <?php }
    } ?>
</div>
<?php
// $paging = ob_get_contents();
// $paging = preg_replace_callback('/href="([^"]+)"/is', function($matches) {
//     $url = $matches[1];
//     $newUrl = '';
//     if ($arUrl = parse_url($url)) {
//         $newUrl .= $arUrl['path'];
//         if (substr($newUrl, -1) != '/') {
//             $newUrl .= '/';
//         }
//         $newUrl = preg_replace('#(pagen[\d]+/)#is', '', $newUrl);
//         parse_str(htmlspecialcharsback($arUrl['query']), $arQuery);
//         foreach ($arQuery as $k => $v) {
//             if (in_array($k, array('SECTION_CODE'))) {
//                 unset($arQuery[$k]);
//             } elseif (substr($k, 0, 5)=='PAGEN') {
//                 $arQuery['page'] = intval($v);
//                 // $newUrl .= 'pagen'.intval($v).'/';
//                 unset($arQuery[$k]);
//             }
//         }
//         $buildQuery = http_build_query($arQuery, '', '&amp;');
//         if (strlen($buildQuery)) {
//             $newUrl .= '?'.$buildQuery;
//         }
//     }
//     return 'href="'.$newUrl.'"';
// }, $paging);
// ob_end_clean();
// echo $paging;