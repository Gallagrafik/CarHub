<?php
header('Content-Type: application/json; charset=utf-8');
include 'script.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // POST — сохранение формы (ЛР5)
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Некорректные данные']);
        exit;
    }

    $saved = saveFeedback($name, $email, $phone, $message);

    echo json_encode([
        'success' => $saved,
        'message' => $saved ? 'Заявка успешно отправлена!' : 'Ошибка сохранения в БД',
        'cars'    => $saved ? getCars() : []
    ]);
    exit;
}

if ($method === 'GET') {
    // GET — обновление списка автомобилей (ЛР5)
    echo json_encode(getCars());
    exit;
}

echo json_encode(['error' => 'Метод не поддерживается']);
?>