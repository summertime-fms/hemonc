<?php

/*
 * AlexBazowsky @github
 * for Headache since aug 2023
 */

global $reviews_service_detail_filter;
if (isset($arResult['PROPERTIES']['REVIEWS']['VALUE']) && !empty($arResult['PROPERTIES']['REVIEWS']['VALUE'])) {
    $reviews_service_detail_filter = [
        'ID' => $arResult['PROPERTIES']['REVIEWS']['VALUE'],
    ];
}

global $advantages_service_detail_filter;
if (isset($arResult['PROPERTIES']['ADVANTAGES']['VALUE']) && !empty($arResult['PROPERTIES']['ADVANTAGES']['VALUE'])) {
    $advantages_service_detail_filter = [
        'ID' => $arResult['PROPERTIES']['ADVANTAGES']['VALUE'],
    ];
}

global $doctors_service_detail_filter;
$doctors_service_detail_filter = false;
if (isset($arResult['PROPERTIES']['DOCTORS']['VALUE']) && !empty($arResult['PROPERTIES']['DOCTORS']['VALUE'])) {
    $doctors_service_detail_filter = [
        'ID' => $arResult['PROPERTIES']['DOCTORS']['VALUE'],
    ];
}

$arResult['AUTHOR'] = false;
if (isset($arResult['PROPERTIES']['AUTHOR_TEXT_AUTHOR']['VALUE']) && !empty($arResult['PROPERTIES']['AUTHOR_TEXT_AUTHOR']['VALUE'])) {
    $arResult['AUTHOR'] = \CIBlockElement::GetList(
        [],
        [
            "IBLOCK_ID" => $arResult['PROPERTIES']['AUTHOR_TEXT_AUTHOR']['LINK_IBLOCK_ID'],
            "ID"        => $arResult['PROPERTIES']['AUTHOR_TEXT_AUTHOR']['VALUE'],
        ],
        false,
        false,
        [
            'ID',
            'CODE',
            'NAME',
            'PREVIEW_PICTURE',
            'PROPERTY_MID_NAME',
            'PROPERTY_FIRST_NAME',
            'PROPERTY_TITLE',
            'PROPERTY_TITLE2',
            'PROPERTY_PRICE_CLINIC',
            'PROPERTY_PRICE_ONLINE',
            'PROPERTY_ONES_GUID',
            'DETAIL_PAGE_URL',
        ],
    )->getNext();

    $arResult['AUTHOR']['PREVIEW_PICTURE'] = [
        'SRC' => \CFile::GetPath($arResult['AUTHOR']["PREVIEW_PICTURE"]),
        'ID'  => $arResult['AUTHOR']['PREVIEW_PICTURE'],
    ];

    $arResult['AUTHOR']['FULL_NAME'] = $arResult['AUTHOR']['NAME'] . ' ' . $arResult['AUTHOR']['PROPERTY_FIRST_NAME_VALUE'] . ' ' . $arResult['AUTHOR']['PROPERTY_MID_NAME_VALUE'];
}

$arResult['GALLERY'] = false;
if ($arResult['PROPERTIES']['GALLERY']['VALUE'] && count($arResult['PROPERTIES']['GALLERY']['VALUE'])) {
    foreach ($arResult['PROPERTIES']['GALLERY']['VALUE'] as $value) {
        $arResult['GALLERY'][] = \CFile::GetPath($value);
    }
}

global $video_service_detail_filter;
$video_service_detail_filter = [
    '!=PROPERTY_VIDEO_LINK' => false,
];
if (isset($arResult['PROPERTIES']['VIDEO']['VALUE']) && !empty($arResult['PROPERTIES']['VIDEO']['VALUE'])) {
    $video_service_detail_filter = [
        'ID' => $arResult['PROPERTIES']['VIDEO']['VALUE'],
        '!=PROPERTY_VIDEO_LINK' => false,
    ];
}

global $faq_top_service_detail_filter;
if (isset($arResult['PROPERTIES']['FAQ_TOP_LINK']['VALUE']) && !empty($arResult['PROPERTIES']['FAQ_TOP_LINK']['VALUE'])) {
    $faq_top_service_detail_filter = [
        'ID' => $arResult['PROPERTIES']['FAQ_TOP_LINK']['VALUE'],
    ];
}

global $faq_bottom_service_detail_filter;
if (isset($arResult['PROPERTIES']['FAQ_BOTTOM_LINK']['VALUE']) && !empty($arResult['PROPERTIES']['FAQ_BOTTOM_LINK']['VALUE'])) {
    $faq_bottom_service_detail_filter = [
        'ID' => $arResult['PROPERTIES']['FAQ_BOTTOM_LINK']['VALUE'],
    ];
}


$arResult['CHEMO_SCHEME_HL'] = null;
$arResult['CHEMO_SCHEME_HL_LIST'] = [];

$iblockId = (int) ($arResult['IBLOCK_ID'] ?? 0);
$elementId = (int) ($arResult['ID'] ?? 0);

$collectHlRefRawList = static function (string $propCode) use ($arResult, $iblockId, $elementId): array {
    $rawList = [];
    $prop = $arResult['PROPERTIES'][$propCode] ?? null;
    if (is_array($prop)) {
        $rawVal = $prop['VALUE'] ?? null;
        if ($rawVal === null || $rawVal === '' || $rawVal === false) {
            $rawVal = $prop['~VALUE'] ?? null;
        }
        if (is_array($rawVal)) {
            foreach ($rawVal as $one) {
                if (is_array($one)) {
                    $one = $one['ID'] ?? reset($one);
                }
                $s = trim((string) $one);
                if ($s !== '') {
                    $rawList[] = $s;
                }
            }
        } elseif ($rawVal !== null && $rawVal !== '' && $rawVal !== false) {
            $rawList[] = trim((string) $rawVal);
        }
    }

    if ($rawList === [] && $iblockId > 0 && $elementId > 0) {
        $dbProp = \CIBlockElement::GetProperty($iblockId, $elementId, ['sort' => 'asc', 'id' => 'asc'], ['CODE' => $propCode]);
        while ($propRow = $dbProp->Fetch()) {
            $v = $propRow['VALUE'] ?? $propRow['~VALUE'] ?? null;
            if (is_array($v)) {
                $v = isset($v['ID']) ? $v['ID'] : reset($v);
            }
            $s = trim((string) $v);
            if ($s !== '') {
                $rawList[] = $s;
            }
        }
    }

    $seen = [];
    $unique = [];
    foreach ($rawList as $s) {
        if (!isset($seen[$s])) {
            $seen[$s] = true;
            $unique[] = $s;
        }
    }

    return $unique;
};

$schemesRawList = $collectHlRefRawList('SCHEMES');
$diagnosisRawList = $collectHlRefRawList('DIAGNOSIS');

$arDxHlSettings = [];
$dxHlBlockId = (defined('HL_DIAGNOSES_MKB_ID') && (int) HL_DIAGNOSES_MKB_ID > 0) ? (int) HL_DIAGNOSES_MKB_ID : 0;
if ($iblockId > 0) {
    $propMetaDx = \CIBlockProperty::GetList([], ['IBLOCK_ID' => $iblockId, 'CODE' => 'DIAGNOSIS'])->Fetch();
    if (is_array($propMetaDx)) {
        $uts = $propMetaDx['USER_TYPE_SETTINGS'] ?? '';
        $arDxHlSettings = is_array($uts) ? $uts : [];
        if ($arDxHlSettings === [] && is_string($uts) && $uts !== '') {
            $arDxHlSettings = (array) @unserialize($uts, ['allowed_classes' => false]);
            if ($arDxHlSettings === [] && strpos(trim($uts), '{') === 0) {
                $arDxHlSettings = (array) json_decode($uts, true);
            }
        }
        $hlFromProp = (int) ($arDxHlSettings['HLBLOCK_ID'] ?? $arDxHlSettings['HLBLOCK'] ?? 0);
        if ($hlFromProp > 0) {
            $dxHlBlockId = $hlFromProp;
        }
    }
}

$parseHlPropSettings = static function (?array $propMeta): array {
    if (!is_array($propMeta)) {
        return [];
    }
    $uts = $propMeta['USER_TYPE_SETTINGS'] ?? '';
    $settings = is_array($uts) ? $uts : [];
    if ($settings === [] && is_string($uts) && $uts !== '') {
        $settings = (array) @unserialize($uts, ['allowed_classes' => false]);
        if ($settings === [] && strpos(trim($uts), '{') === 0) {
            $settings = (array) json_decode($uts, true);
        }
    }

    return $settings;
};

$arSchemesHlSettings = [];
$arChemoHlSettings = [];
$hlBlockId = (defined('HL_CHEMO_SCHEMES_ID') && (int) HL_CHEMO_SCHEMES_ID > 0) ? (int) HL_CHEMO_SCHEMES_ID : 0;
if ($iblockId > 0) {
    $propMetaSchemes = \CIBlockProperty::GetList([], ['IBLOCK_ID' => $iblockId, 'CODE' => 'SCHEMES'])->Fetch();
    $arSchemesHlSettings = $parseHlPropSettings(is_array($propMetaSchemes) ? $propMetaSchemes : null);
    $hlFromSchemes = (int) ($arSchemesHlSettings['HLBLOCK_ID'] ?? $arSchemesHlSettings['HLBLOCK'] ?? 0);
    if ($hlFromSchemes > 0) {
        $hlBlockId = $hlFromSchemes;
    }

    $propMetaChemo = \CIBlockProperty::GetList([], ['IBLOCK_ID' => $iblockId, 'CODE' => 'CHEMO_SCHEME'])->Fetch();
    $arChemoHlSettings = $parseHlPropSettings(is_array($propMetaChemo) ? $propMetaChemo : null);
    if ($hlFromSchemes <= 0) {
        $hlFromProp = (int) ($arChemoHlSettings['HLBLOCK_ID'] ?? $arChemoHlSettings['HLBLOCK'] ?? 0);
        if ($hlFromProp > 0) {
            $hlBlockId = $hlFromProp;
        }
    }
}

if (\Bitrix\Main\Loader::includeModule('highloadblock')) {
    $tableNameDx = trim((string) ($arDxHlSettings['TABLE_NAME'] ?? ''));
    if ($tableNameDx !== '') {
        $hlBlockRowDx = \Bitrix\Highloadblock\HighloadBlockTable::getList([
            'filter' => ['=TABLE_NAME' => $tableNameDx],
            'limit' => 1,
        ])->fetch();
        if (is_array($hlBlockRowDx)) {
            $dxHlBlockId = (int) $hlBlockRowDx['ID'];
        }
    }
    $tableNameSchemes = trim((string) ($arSchemesHlSettings['TABLE_NAME'] ?? ''));
    if ($tableNameSchemes !== '') {
        $hlBlockRowSchemes = \Bitrix\Highloadblock\HighloadBlockTable::getList([
            'filter' => ['=TABLE_NAME' => $tableNameSchemes],
            'limit' => 1,
        ])->fetch();
        if (is_array($hlBlockRowSchemes)) {
            $hlBlockId = (int) $hlBlockRowSchemes['ID'];
        }
    }
    if ($tableNameSchemes === '') {
        $tableNameChemo = trim((string) ($arChemoHlSettings['TABLE_NAME'] ?? ''));
        if ($tableNameChemo !== '') {
            $hlBlockRowChemo = \Bitrix\Highloadblock\HighloadBlockTable::getList([
                'filter' => ['=TABLE_NAME' => $tableNameChemo],
                'limit' => 1,
            ])->fetch();
            if (is_array($hlBlockRowChemo)) {
                $hlBlockId = (int) $hlBlockRowChemo['ID'];
            }
        }
    }
}

$mkbSet = [];
if ($diagnosisRawList !== [] && $dxHlBlockId > 0 && \Bitrix\Main\Loader::includeModule('highloadblock')) {
    $hlBlockDx = \Bitrix\Highloadblock\HighloadBlockTable::getById($dxHlBlockId)->fetch();
    if ($hlBlockDx) {
        $entityDx = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlBlockDx);
        $dataClassDx = $entityDx->getDataClass();

        foreach ($diagnosisRawList as $dxRawStr) {
            $dxRawStr = trim((string) $dxRawStr);
            if ($dxRawStr === '') {
                continue;
            }

            $dxRow = null;
            if (preg_match('/^\d+$/', $dxRawStr)) {
                $dxRow = $dataClassDx::getList([
                    'filter' => ['=ID' => (int) $dxRawStr],
                    'limit' => 1,
                ])->fetch();
            } elseif (is_numeric($dxRawStr) && strpos($dxRawStr, '.') !== false) {
                $dxRow = $dataClassDx::getList([
                    'filter' => ['=ID' => (int) round((float) $dxRawStr)],
                    'limit' => 1,
                ])->fetch();
            }
            if ($dxRow === null) {
                $dxRow = $dataClassDx::getList([
                    'filter' => ['=UF_XML_ID' => $dxRawStr],
                    'limit' => 1,
                ])->fetch();
            }

            if (!is_array($dxRow)) {
                continue;
            }
            $code = (string) ($dxRow['UF_MKB_CODE'] ?? '');
            if ($code === '') {
                $code = (string) ($dxRow['UF_XML_ID'] ?? '');
            }
            $norm = mb_strtoupper(trim($code));
            if ($norm !== '') {
                $mkbSet[$norm] = true;
            }
        }
    }
}

$normalizeMkb = static function (string $m): string {
    return mb_strtoupper(trim($m));
};

$chemoSchemeMatchesMkbSet = static function (array $schemeRow, array $mkbKeys) use ($normalizeMkb): bool {
    $raw = $schemeRow['UF_DIAGNOSES'] ?? '';
    if (!is_string($raw) || $raw === '') {
        return false;
    }
    $decoded = json_decode($raw, true);
    if (!is_array($decoded)) {
        return false;
    }
    foreach ($decoded as $item) {
        if (!is_array($item)) {
            continue;
        }
        $mkb = $normalizeMkb((string) ($item['mkb'] ?? ''));
        if ($mkb !== '' && isset($mkbKeys[$mkb])) {
            return true;
        }
    }

    return false;
};

if ($hlBlockId > 0 && \Bitrix\Main\Loader::includeModule('highloadblock')) {
    $hlBlock = \Bitrix\Highloadblock\HighloadBlockTable::getById($hlBlockId)->fetch();
    if ($hlBlock) {
        $entity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlBlock);
        $entityDataClass = $entity->getDataClass();

        if ($schemesRawList !== []) {
            $seenHlId = [];
            foreach ($schemesRawList as $schemeRawStr) {
                $schemeRawStr = trim((string) $schemeRawStr);
                if ($schemeRawStr === '') {
                    continue;
                }

                $schemeRow = null;
                if (preg_match('/^\d+$/', $schemeRawStr)) {
                    $schemeRow = $entityDataClass::getList([
                        'filter' => ['=ID' => (int) $schemeRawStr],
                        'limit' => 1,
                    ])->fetch();
                } elseif (is_numeric($schemeRawStr) && strpos($schemeRawStr, '.') !== false) {
                    $schemeRow = $entityDataClass::getList([
                        'filter' => ['=ID' => (int) round((float) $schemeRawStr)],
                        'limit' => 1,
                    ])->fetch();
                }
                if ($schemeRow === null) {
                    $schemeRow = $entityDataClass::getList([
                        'filter' => ['=UF_XML_ID' => $schemeRawStr],
                        'limit' => 1,
                    ])->fetch();
                }

                if (!is_array($schemeRow)) {
                    continue;
                }
                $hid = (int) ($schemeRow['ID'] ?? 0);
                if ($hid > 0 && !isset($seenHlId[$hid])) {
                    $seenHlId[$hid] = true;
                    $arResult['CHEMO_SCHEME_HL_LIST'][] = $schemeRow;
                }
            }
        } elseif ($mkbSet !== []) {
            $seenHlId = [];
            $res = $entityDataClass::getList([
                'order' => ['ID' => 'ASC'],
            ]);
            while ($schemeData = $res->fetch()) {
                if (!is_array($schemeData)) {
                    continue;
                }
                if (!$chemoSchemeMatchesMkbSet($schemeData, $mkbSet)) {
                    continue;
                }
                $hid = (int) ($schemeData['ID'] ?? 0);
                if ($hid > 0 && !isset($seenHlId[$hid])) {
                    $seenHlId[$hid] = true;
                    $arResult['CHEMO_SCHEME_HL_LIST'][] = $schemeData;
                }
            }
        }

        if ($arResult['CHEMO_SCHEME_HL_LIST'] !== []) {
            $arResult['CHEMO_SCHEME_HL'] = $arResult['CHEMO_SCHEME_HL_LIST'][0];
        }
    }
}

if ($arResult['CHEMO_SCHEME_HL_LIST'] !== [] && $dxHlBlockId > 0 && \Bitrix\Main\Loader::includeModule('highloadblock')) {
    $diagCodes = [];
    foreach ($arResult['CHEMO_SCHEME_HL_LIST'] as $schemeRow) {
        if (!is_array($schemeRow)) {
            continue;
        }
        $raw = $schemeRow['UF_DIAGNOSES'] ?? '';
        if (!is_string($raw) || $raw === '') {
            continue;
        }
        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) {
            continue;
        }
        foreach ($decoded as $item) {
            if (!is_array($item)) {
                continue;
            }
            $mkb = $normalizeMkb((string) ($item['mkb'] ?? ''));
            if ($mkb !== '') {
                $diagCodes[$mkb] = true;
            }
        }
    }

    if ($diagCodes !== []) {
        $dxHlBlock = \Bitrix\Highloadblock\HighloadBlockTable::getById($dxHlBlockId)->fetch();
        if ($dxHlBlock) {
            $dxEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($dxHlBlock);
            $dxDataClass = $dxEntity->getDataClass();

            $codes = array_keys($diagCodes);
            $shortByCode = [];
            $dxRes = $dxDataClass::getList([
                'select' => ['UF_MKB_CODE', 'UF_XML_ID', 'UF_SHORTNAME'],
                'filter' => [
                    [
                        'LOGIC' => 'OR',
                        ['@UF_MKB_CODE' => $codes],
                        ['@UF_XML_ID' => $codes],
                    ],
                ],
            ]);
            while ($dxRow = $dxRes->fetch()) {
                $short = trim((string) ($dxRow['UF_SHORTNAME'] ?? ''));
                if ($short === '') {
                    continue;
                }
                $codeByMkb = $normalizeMkb((string) ($dxRow['UF_MKB_CODE'] ?? ''));
                $codeByXml = $normalizeMkb((string) ($dxRow['UF_XML_ID'] ?? ''));
                if ($codeByMkb !== '' && !isset($shortByCode[$codeByMkb])) {
                    $shortByCode[$codeByMkb] = $short;
                }
                if ($codeByXml !== '' && !isset($shortByCode[$codeByXml])) {
                    $shortByCode[$codeByXml] = $short;
                }
            }

            if ($shortByCode !== []) {
                foreach ($arResult['CHEMO_SCHEME_HL_LIST'] as $i => $schemeRow) {
                    if (!is_array($schemeRow)) {
                        continue;
                    }
                    $raw = $schemeRow['UF_DIAGNOSES'] ?? '';
                    if (!is_string($raw) || $raw === '') {
                        continue;
                    }
                    $decoded = json_decode($raw, true);
                    if (!is_array($decoded)) {
                        continue;
                    }
                    $changed = false;
                    foreach ($decoded as $k => $item) {
                        if (!is_array($item)) {
                            continue;
                        }
                        $mkb = $normalizeMkb((string) ($item['mkb'] ?? ''));
                        if ($mkb === '' || !isset($shortByCode[$mkb])) {
                            continue;
                        }
                        $decoded[$k]['UF_SHORTNAME'] = $shortByCode[$mkb];
                        $decoded[$k]['shortname'] = $shortByCode[$mkb];
                        $changed = true;
                    }
                    if ($changed) {
                        $arResult['CHEMO_SCHEME_HL_LIST'][$i]['UF_DIAGNOSES'] = json_encode($decoded, JSON_UNESCAPED_UNICODE);
                    }
                }
                if ($arResult['CHEMO_SCHEME_HL_LIST'] !== []) {
                    $arResult['CHEMO_SCHEME_HL'] = $arResult['CHEMO_SCHEME_HL_LIST'][0];
                }
            }
        }
    }
}
