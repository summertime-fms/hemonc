<?php

if (php_sapi_name() === 'cli') {
    return;
}

$requestUri = (string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
if ($requestUri === '' || str_starts_with($requestUri, '/bitrix/')) {
    return;
}

$redirectsFile = $_SERVER['DOCUMENT_ROOT'] . '/rekomendatsii/.guide_redirects.php';
if (!is_file($redirectsFile)) {
    return;
}

$redirects = require $redirectsFile;
if (!is_array($redirects)) {
    return;
}

$target = $redirects[$requestUri] ?? null;
if (!is_string($target) || $target === '' || $target === $requestUri) {
    return;
}

$query = (string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_QUERY);
if ($query !== '') {
    $target .= '?' . $query;
}

LocalRedirect($target, true, '301 Moved Permanently');
