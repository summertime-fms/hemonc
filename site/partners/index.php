<?php

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';

$partnersConfig = require __DIR__ . '/.partners_config.php';

$APPLICATION->IncludeComponent(
    'bitrix:news.detail',
    'page_text',
    [
        'ACTIVE_DATE_FORMAT'        => 'j F Y',
        'ADD_ELEMENT_CHAIN'         => 'N',
        'ADD_SECTIONS_CHAIN'        => 'N',
        'AJAX_MODE'                 => 'N',
        'AJAX_OPTION_ADDITIONAL'    => '',
        'AJAX_OPTION_HISTORY'       => 'N',
        'AJAX_OPTION_JUMP'          => 'N',
        'AJAX_OPTION_STYLE'         => 'N',
        'BROWSER_TITLE'             => 'TITLE',
        'CACHE_GROUPS'              => 'N',
        'CACHE_TIME'                => '36000000',
        'CACHE_TYPE'                => 'A',
        'CHECK_DATES'               => 'Y',
        'COMPOSITE_FRAME_MODE'      => 'A',
        'COMPOSITE_FRAME_TYPE'      => 'AUTO',
        'ELEMENT_CODE'              => $partnersConfig['PAGE_ELEMENT_CODE'],
        'ELEMENT_ID'                => '',
        'FIELD_CODE'                => [],
        'IBLOCK_ID'                 => (string) $partnersConfig['PAGES_IBLOCK_ID'],
        'IBLOCK_TYPE'               => 'site',
        'IBLOCK_URL'                => '',
        'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
        'MESSAGE_404'               => '',
        'META_DESCRIPTION'          => 'DESCRIPTION',
        'META_KEYWORDS'             => 'KEYWORDS',
        'PROPERTY_CODE'             => [],
        'SET_BROWSER_TITLE'         => 'Y',
        'SET_CANONICAL_URL'         => 'Y',
        'SET_LAST_MODIFIED'         => 'N',
        'SET_META_DESCRIPTION'      => 'Y',
        'SET_META_KEYWORDS'         => 'N',
        'SET_STATUS_404'            => 'N',
        'SET_TITLE'                 => 'Y',
        'SHOW_404'                  => 'N',
        'STRICT_SECTION_CHECK'      => 'N',
        'USE_PERMISSIONS'           => 'N',
        'CSS_CLASS_BODY'            => 'partners-page',
        'CSS_CLASS_HEADER'          => 'default-main-block-header full-width',
        'HEADER_TEXT_CONTAINER'     => 'header-content',
    ],
);
?>

<div class="contacts-main-block partners-main-block">
    <div class="wrapper">
        <?php
        $listParams = [
            'COMPONENT_TEMPLATE'        => 'partners_list',
            'IBLOCK_TYPE'               => $partnersConfig['IBLOCK_TYPE'],
            'IBLOCK_CODE'               => $partnersConfig['IBLOCK_CODE'],
            'NEWS_COUNT'                => '200',
            'SORT_BY1'                  => 'SORT',
            'SORT_ORDER1'               => 'ASC',
            'SORT_BY2'                  => 'NAME',
            'SORT_ORDER2'               => 'ASC',
            'FILTER_NAME'               => '',
            'FIELD_CODE'                => ['PREVIEW_PICTURE', 'NAME'],
            'PROPERTY_CODE'             => ['LINK'],
            'CHECK_DATES'               => 'Y',
            'AJAX_MODE'                 => 'N',
            'AJAX_OPTION_JUMP'          => 'N',
            'AJAX_OPTION_STYLE'         => 'Y',
            'AJAX_OPTION_HISTORY'       => 'N',
            'AJAX_OPTION_ADDITIONAL'    => '',
            'CACHE_TYPE'                => 'A',
            'CACHE_TIME'                => '36000000',
            'CACHE_FILTER'              => 'N',
            'CACHE_GROUPS'              => 'N',
            'SET_TITLE'                 => 'N',
            'SET_BROWSER_TITLE'         => 'N',
            'SET_META_KEYWORDS'         => 'N',
            'SET_META_DESCRIPTION'      => 'N',
            'SET_LAST_MODIFIED'         => 'N',
            'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
            'ADD_SECTIONS_CHAIN'        => 'N',
            'HIDE_LINK_WHEN_NO_DETAIL'  => 'N',
            'PARENT_SECTION'            => '',
            'PARENT_SECTION_CODE'       => '',
            'INCLUDE_SUBSECTIONS'       => 'N',
            'STRICT_SECTION_CHECK'      => 'N',
            'DISPLAY_DATE'              => 'N',
            'DISPLAY_NAME'              => 'N',
            'DISPLAY_PICTURE'           => 'Y',
            'DISPLAY_PREVIEW_TEXT'      => 'N',
            'PAGER_TEMPLATE'            => '.default',
            'DISPLAY_TOP_PAGER'         => 'N',
            'DISPLAY_BOTTOM_PAGER'      => 'N',
            'SET_STATUS_404'            => 'N',
            'SHOW_404'                  => 'N',
            'MESSAGE_404'               => '',
        ];

        if (!empty($partnersConfig['IBLOCK_ID'])) {
            $listParams['IBLOCK_ID'] = (string) $partnersConfig['IBLOCK_ID'];
            unset($listParams['IBLOCK_CODE']);
        }

        $APPLICATION->IncludeComponent(
            'bitrix:news.list',
            'partners_list',
            $listParams,
            false,
        );
        ?>
    </div>
</div>
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
