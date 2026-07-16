<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
?>
<article class="main-content">
    <div class="wrapper">
        <?php
        $APPLICATION->IncludeComponent(
            "bitrix:main.map",
            "",
            [
                "CACHE_TYPE" => "N",
                "COL_NUM" => "1",
                "LEVEL" => "3",
                "SET_TITLE" => "Y",
                "SHOW_DESCRIPTION" => "N"
            ],
        );

        $APPLICATION->IncludeComponent(
            "bitrix:news.index",
            "",
            [
                "ACTIVE_DATE_FORMAT"   => "d.m.Y",
                "CACHE_GROUPS"         => "N",
                "CACHE_TIME"           => "36000000",
                "CACHE_TYPE"           => "N",
                "COMPOSITE_FRAME_MODE" => "A",
                "COMPOSITE_FRAME_TYPE" => "AUTO",
                "DETAIL_URL"           => "",
                "FIELD_CODE"           => ["", ""],
                "FILTER_NAME"          => "arrFilter",
                "IBLOCKS"              => [19,16,17,15],
                "IBLOCK_SORT_BY"       => "SORT",
                "IBLOCK_SORT_ORDER"    => "ASC",
                "NEWS_COUNT"           => "500",
                "PROPERTY_CODE"        => ["", ""],
                "SORT_BY1"             => "ACTIVE_FROM",
                "SORT_BY2"             => "SORT",
                "SORT_ORDER1"          => "DESC",
                "SORT_ORDER2"          => "ASC",
            ],
        );
        ?>
    </div>
</article>

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
