<?php

/**
 * Одноразовая настройка раздела «Партнёры».
 *
 * CLI: php /var/www/html/local/php_interface/partners_setup.php
 * Web: /local/php_interface/partners_setup.php?token=setup-partners
 */

$_SERVER['DOCUMENT_ROOT'] = realpath(__DIR__ . '/../..');
require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

if (PHP_SAPI !== 'cli') {
    $token = (string) ($_GET['token'] ?? '');
    if ($token !== 'setup-partners') {
        http_response_code(403);
        exit('Forbidden');
    }
}

if (!\Bitrix\Main\Loader::includeModule('iblock')) {
    exit("Module iblock is not available\n");
}

$pagesIblockId = 7;
$partnersIblockCode = 'partners';
$partnersIblockType = 'content';
$pageElementCode = 'partners';
$configPath = $_SERVER['DOCUMENT_ROOT'] . '/partners/.partners_config.php';

function partnersSetupLog(string $message): void
{
    echo $message . PHP_EOL;
}

function partnersSetupGetIblockIdByCode(string $code, string $type): ?int
{
    $res = CIBlock::GetList([], ['CODE' => $code, 'TYPE' => $type, 'CHECK_PERMISSIONS' => 'N']);
    if ($row = $res->Fetch()) {
        return (int) $row['ID'];
    }

    return null;
}

function partnersSetupEnsureProperty(int $iblockId, string $code, string $name): void
{
    $res = CIBlockProperty::GetList([], ['IBLOCK_ID' => $iblockId, 'CODE' => $code]);
    if ($res->Fetch()) {
        partnersSetupLog("Property {$code} already exists");
        return;
    }

    $property = new CIBlockProperty();
    $propertyId = $property->Add([
        'IBLOCK_ID'     => $iblockId,
        'NAME'          => $name,
        'ACTIVE'        => 'Y',
        'SORT'          => 100,
        'CODE'          => $code,
        'PROPERTY_TYPE' => 'S',
        'ROW_COUNT'     => 1,
        'COL_COUNT'     => 60,
        'MULTIPLE'      => 'N',
        'IS_REQUIRED'   => 'N',
    ]);

    if (!$propertyId) {
        throw new RuntimeException('Failed to create property ' . $code . ': ' . $property->LAST_ERROR);
    }

    partnersSetupLog("Property {$code} created (ID {$propertyId})");
}

function partnersSetupEnsurePageElement(int $iblockId, string $code): void
{
    $res = CIBlockElement::GetList([], ['IBLOCK_ID' => $iblockId, 'CODE' => $code], false, false, ['ID']);
    if ($res->Fetch()) {
        partnersSetupLog("Page element {$code} already exists");
        return;
    }

    $element = new CIBlockElement();
    $elementId = $element->Add([
        'IBLOCK_ID'          => $iblockId,
        'NAME'               => 'Партнёры',
        'CODE'               => $code,
        'ACTIVE'             => 'Y',
        'SORT'               => 500,
        'PREVIEW_TEXT'       => "ПАРТНЁРЫ\r\n\r\nКЛИНИКА ДОКТОРА ЛАСКОВА СОТРУДНИЧАЕТ С ВЕДУЩИМИ ОРГАНИЗАЦИЯМИ В ОБЛАСТИ ОНКОЛОГИИ.",
        'PREVIEW_TEXT_TYPE'  => 'text',
        'DETAIL_TEXT'        => '<p>Мы сотрудничаем с ведущими организациями в области онкологии и смежных направлений. Ниже представлены наши партнёры.</p>',
        'DETAIL_TEXT_TYPE'   => 'html',
        'IPROPERTY_TEMPLATES' => [
            'ELEMENT_META_TITLE'       => 'Партнёры | Клиника доктора Ласкова',
            'ELEMENT_META_DESCRIPTION' => 'Партнёры клиники доктора Ласкова: организации и компании, с которыми мы сотрудничаем.',
            'ELEMENT_META_KEYWORDS'      => 'партнёры, клиника доктора Ласкова, сотрудничество',
        ],
    ]);

    if (!$elementId) {
        throw new RuntimeException('Failed to create page element: ' . $element->LAST_ERROR);
    }

    partnersSetupLog("Page element {$code} created (ID {$elementId})");
}

function partnersSetupUpdateConfig(string $configPath, int $iblockId): void
{
    $config = require $configPath;
    $config['IBLOCK_ID'] = $iblockId;

    $export = var_export($config, true);
    $content = <<<PHP
<?php

/**
 * Конфиг раздела «Партнёры» (/partners/).
 * После создания инфоблока в админке укажите его ID в IBLOCK_ID (опционально).
 */
return {$export};

PHP;

    if (file_put_contents($configPath, $content) === false) {
        throw new RuntimeException('Failed to update config file: ' . $configPath);
    }

    partnersSetupLog('Config updated with IBLOCK_ID=' . $iblockId);
}

$partnersIblockId = partnersSetupGetIblockIdByCode($partnersIblockCode, $partnersIblockType);

if (!$partnersIblockId) {
    $iblock = new CIBlock();
    $partnersIblockId = (int) $iblock->Add([
        'ACTIVE'         => 'Y',
        'NAME'           => 'Партнёры',
        'CODE'           => $partnersIblockCode,
        'IBLOCK_TYPE_ID' => $partnersIblockType,
        'SITE_ID'        => ['s1'],
        'SORT'           => 500,
        'GROUP_ID'       => ['2' => 'R'],
        'VERSION'        => 1,
        'INDEX_ELEMENT'  => 'N',
        'LIST_PAGE_URL'  => '/partners/',
        'DETAIL_PAGE_URL'=> '',
    ]);

    if (!$partnersIblockId) {
        throw new RuntimeException('Failed to create iblock partners: ' . $iblock->LAST_ERROR);
    }

    partnersSetupLog("Iblock partners created (ID {$partnersIblockId})");
} else {
    partnersSetupLog("Iblock partners already exists (ID {$partnersIblockId})");
}

partnersSetupEnsureProperty($partnersIblockId, 'LINK', 'Ссылка на сайт');
partnersSetupEnsurePageElement($pagesIblockId, $pageElementCode);
partnersSetupUpdateConfig($configPath, $partnersIblockId);

partnersSetupLog('Partners setup completed');
