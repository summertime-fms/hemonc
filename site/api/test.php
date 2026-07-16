<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'errors' => ['Метод не разрешён']]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (json_last_error() === JSON_ERROR_NONE && is_array($input)) {
    $data = $input;
} else {
    $data = $_POST;
}

if (!empty($data['needsErrors'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'errors' => ['Укажите имя', 'Укажите телефон']
    ]);
    exit;
}

// Иначе успешный ответ
echo json_encode([
    'success' => true,
    'message' => 'Заявка отправлена'
]);
