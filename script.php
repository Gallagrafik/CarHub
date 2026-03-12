<?php
// script.php — подключение к БД и функции

define('DB_HOST', '127.0.1.19');         // из лога MariaDB — точный IP
define('DB_USER', 'root');
define('DB_PASS', '');              // пустой пароль в OpenServer
define('DB_NAME', 'carhub_db');

try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}

// Получить все автомобили
function getCars() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM cars ORDER BY title ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Сохранить сообщение из формы
function saveFeedback($name, $email, $phone, $message) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO feedback (name, email, phone, message) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $email, $phone, $message]);
}
?>