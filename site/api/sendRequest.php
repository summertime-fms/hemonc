<?php
header("Content-Type: application/json; charset=utf-8");

$allowedOrigin = 'https://hemonc.ru';

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';

if (
    (empty($origin) || strpos($origin, $allowedOrigin) !== 0) &&
    (empty($referer) || strpos($referer, $allowedOrigin) !== 0)
) {
    http_response_code(403);
    exit(json_encode(['success' => false]));
}

$webhook = 'https://laskov-partners.bitrix24.ru/rest/19128/o45cv626xpk47qe4/';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$name = trim($_POST['name'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$speciality = trim($_POST['speciality'] ?? '');
$comment = trim($_POST['comment'] ?? '');

$errors = [];
if (empty($name)) {
    $errors[] = 'Укажите имя';
}
if (empty($phone)) {
    $errors[] = 'Укажите телефон';
}
if (empty($speciality)) {
    $errors[] = 'Выберите специализацию';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

$phoneClean = preg_replace('/[^0-9+]/', '', $phone);
if (!preg_match('/^\+?\d{10,15}$/', $phoneClean)) {
    $phoneClean = $phone;
}

$leadData = [
    'fields' => [
        'TITLE' => 'Заявка с лендинга',
        'NAME' => $name,

        'PHONE' => [['VALUE' => $phoneClean, 'VALUE_TYPE' => 'WORK']],
        'COMMENTS' => $comment,
        'UF_CRM_1774262192' => $speciality,
    ],
    'params' => ['REGISTER_SONET_EVENT' => 'Y']
];

$url = rtrim($webhook, '/') . '/crm.lead.add.json';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($leadData));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    $logMessage = date('Y-m-d H:i:s') . " cURL ошибка: $curlError\n";
    file_put_contents('/var/www/hemonc/log/langing_request_error.log', $logMessage, FILE_APPEND);
    http_response_code(500);
    echo json_encode(['success' => false, 'errors' => ['Ошибка отправки данных']]);
    exit;
}

$result = json_decode($response, true);
if ($httpCode == 200 && isset($result['result'])) {
    echo json_encode(['success' => true, 'message' => 'Заявка отправлена']);
} else {
    $errorMsg = $result['error_description'] ?? 'Неизвестная ошибка';
    $logMessage = date('Y-m-d H:i:s') . " Ошибка Bitrix24: $errorMsg\n";
    file_put_contents('/var/www/hemonc/log/langing_request_error.log', $logMessage, FILE_APPEND);
    http_response_code(500);
    echo json_encode(['success' => false, 'errors' => ['Ошибка отправки данных']]);
}
