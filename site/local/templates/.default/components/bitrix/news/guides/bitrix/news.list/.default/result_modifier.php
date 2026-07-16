<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    return;
}

$arResult['ALL_TAGS'] = [];
$tagIdByLabel = [];

if (\Bitrix\Main\Loader::includeModule('iblock')) {
    $tagProperty = \CIBlockProperty::GetList(
        [],
        [
            'IBLOCK_ID' => (int) ($arParams['IBLOCK_ID'] ?? 0),
            'CODE'      => 'GUIDE_TAGS',
        ],
    )->Fetch();

    if (is_array($tagProperty)) {
        $enumRes = \CIBlockPropertyEnum::GetList(
            ['SORT' => 'ASC', 'VALUE' => 'ASC'],
            ['PROPERTY_ID' => (int) $tagProperty['ID']],
        );

        while ($enum = $enumRes->Fetch()) {
            $label = trim((string) $enum['VALUE']);
            $id = (string) $enum['ID'];

            $arResult['ALL_TAGS'][] = [
                'ID'    => $id,
                'LABEL' => $label,
            ];

            if ($label !== '') {
                $tagIdByLabel[$label] = $id;
            }
        }
    }
}

foreach ($arResult['ITEMS'] as &$item) {
    $item['GUIDE_TAG_IDS'] = [];
    $tagsProperty = $item['PROPERTIES']['GUIDE_TAGS'] ?? null;

    if (!is_array($tagsProperty) || empty($tagsProperty['VALUE'])) {
        continue;
    }

    $enumIds = $tagsProperty['VALUE_ENUM_ID'] ?? null;
    if (is_array($enumIds) && $enumIds !== []) {
        foreach ($enumIds as $enumId) {
            $enumId = trim((string) $enumId);
            if ($enumId !== '') {
                $item['GUIDE_TAG_IDS'][] = $enumId;
            }
        }
        continue;
    }

    if (!is_array($enumIds) && trim((string) $enumIds) !== '') {
        $item['GUIDE_TAG_IDS'][] = trim((string) $enumIds);
        continue;
    }

    $values = $tagsProperty['VALUE'];
    if (!is_array($values)) {
        $values = [$values];
    }

    foreach ($values as $label) {
        $label = trim((string) $label);
        if ($label !== '' && isset($tagIdByLabel[$label])) {
            $item['GUIDE_TAG_IDS'][] = $tagIdByLabel[$label];
        }
    }
}
unset($item);
