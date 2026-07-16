<?php

define('STOP_STATISTICS', true);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

$request = \Bitrix\Main\Context::getCurrent()->getRequest();
$code = trim((string) $request->get('SHORT_CODE'));

if ($code === '' || !preg_match('/^[A-Za-z0-9~]+$/', $code)) {
    @define('ERROR_404', 'Y');
    CHTTP::SetStatus('404 Not Found');
    require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
    $APPLICATION->SetTitle('Ссылка не найдена');
    ?>
    <main class="main-content">
        <div class="wrapper">
            <p>Ссылка недействительна или устарела.</p>
            <p><a href="/">На главную</a></p>
        </div>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
    return;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/ShortLinkService.php';

try {
    $row = ShortLinkService::findByCode($code);
} catch (Throwable $e) {
    CHTTP::SetStatus('500 Internal Server Error');
    echo 'Service unavailable';
    return;
}

if ($row === null || empty($row['UF_PACIENT_GUID'])) {
    @define('ERROR_404', 'Y');
    CHTTP::SetStatus('404 Not Found');
    require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php';
    $APPLICATION->SetTitle('Ссылка не найдена');
    ?>
    <main class="main-content">
        <div class="wrapper">
            <p>Ссылка недействительна или устарела.</p>
            <p><a href="/">На главную</a></p>
        </div>
    </main>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php';
    return;
}

$guid = (string) $row['UF_PACIENT_GUID'];

LocalRedirect(
    '/apply/?pacient_id=' . rawurlencode($guid),
    true,
    '302 Found'
);
