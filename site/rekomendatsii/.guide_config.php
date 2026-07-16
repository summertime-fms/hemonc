<?php

/**
 * Конфиг раздела «Гайды и инструкции» (/rekomendatsii/).
 * После создания инфоблока в админке укажите его ID в IBLOCK_ID.
 */
return [
    'IBLOCK_ID'   => 29,
    'IBLOCK_TYPE' => 'content',
    'IBLOCK_CODE' => 'guides',
    'SEF_FOLDER'  => '/rekomendatsii/',

    'GUIDE_PROPERTY_CODE' => [
        'GUIDE_TAGS',
        'ARTICLE_DOCTOR',
        'ARTICLE_SOURCES',
    ],
    'GUIDE_FIELD_CODE' => [
        'DETAIL_PICTURE',
        'DETAIL_TEXT',
    ],
    'LIST_PROPERTY_CODE' => [
        'GUIDE_TAGS',
    ],
];
