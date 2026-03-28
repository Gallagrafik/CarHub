<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'script.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
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
        'message' => $saved ? 'Заявка успешно отправлена!' : 'Ошибка сохранения в БД'
    ]);
    exit;
}

// GET — список автомобилей
if ($method === 'GET' && !isset($_GET['action'])) {
    echo json_encode(getCars());
    exit;
}

// GET — список заявок
if (isset($_GET['action']) && $_GET['action'] === 'get_feedbacks') {
    $stmt = $pdo->query("SELECT * FROM feedback ORDER BY created_at DESC LIMIT 50");
    $feedbacks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($feedbacks);
    exit;
}

echo json_encode(['error' => 'Метод не поддерживается']);
?>