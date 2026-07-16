<?php

/*
 * AlexBazowsky @github
 * headachePro bot since aug 2023
 */

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$guideConfig = require __DIR__ . '/.guide_config.php';

$APPLICATION->IncludeComponent(
    'bitrix:news',
    'guides',
    [
        'ADD_ELEMENT_CHAIN'               => 'Y',
        'ADD_SECTIONS_CHAIN'              => 'N',
        'AJAX_MODE'                       => 'N',
        'AJAX_OPTION_ADDITIONAL'          => '',
        'AJAX_OPTION_HISTORY'             => 'Y',
        'AJAX_OPTION_JUMP'                => 'N',
        'AJAX_OPTION_STYLE'               => 'Y',
        'CACHE_FILTER'                    => 'N',
        'CACHE_GROUPS'                    => 'N',
        'CACHE_TIME'                      => '36000000',
        'CACHE_TYPE'                      => 'A',
        'CHECK_DATES'                     => 'Y',
        'COMPOSITE_FRAME_MODE'            => 'A',
        'COMPOSITE_FRAME_TYPE'            => 'AUTO',
        'DETAIL_ACTIVE_DATE_FORMAT'       => 'j F Y',
        'DETAIL_DISPLAY_BOTTOM_PAGER'     => 'N',
        'DETAIL_DISPLAY_TOP_PAGER'        => 'N',
        'DETAIL_FIELD_CODE'               => $guideConfig['GUIDE_FIELD_CODE'],
        'DETAIL_PROPERTY_CODE'            => $guideConfig['GUIDE_PROPERTY_CODE'],
        'DETAIL_SET_CANONICAL_URL'        => 'Y',
        'DISPLAY_BOTTOM_PAGER'            => 'N',
        'DISPLAY_TOP_PAGER'               => 'N',
        'IBLOCK_ID'                       => $guideConfig['IBLOCK_ID'],
        'IBLOCK_TYPE'                     => $guideConfig['IBLOCK_TYPE'],
        'INCLUDE_IBLOCK_INTO_CHAIN'       => 'N',
        'LIST_ACTIVE_DATE_FORMAT'         => 'j F Y',
        'LIST_FIELD_CODE'                 => ['PREVIEW_TEXT'],
        'LIST_PROPERTY_CODE'              => $guideConfig['LIST_PROPERTY_CODE'],
        'BROWSER_TITLE'                   => '-',
        'META_DESCRIPTION'                => '-',
        'META_KEYWORDS'                   => '-',
        'NEWS_COUNT'                      => '50',
        'PAGER_SHOW_ALL'                  => 'N',
        'PAGER_SHOW_ALWAYS'               => 'N',
        'SEF_FOLDER'                      => $guideConfig['SEF_FOLDER'],
        'SEF_MODE'                        => 'Y',
        'SEF_URL_TEMPLATES'               => [
            'detail' => '#ELEMENT_CODE#/',
            'news'   => '',
        ],
        'SET_STATUS_404'                  => 'Y',
        'SET_TITLE'                       => 'Y',
        'SHOW_404'                        => 'Y',
        'SORT_BY1'                        => 'SORT',
        'SORT_ORDER1'                     => 'ASC',
        'SORT_BY2'                        => 'ID',
        'SORT_ORDER2'                     => 'DESC',
        'STRICT_SECTION_CHECK'            => 'N',
    ],
);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
