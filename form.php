<?php
include 'script.php';

$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']    ?? '');
    $email   = trim($_POST['email']   ?? '');
    $phone   = trim($_POST['phone']   ?? '');
    $message = trim($_POST['message'] ?? '');

    // Валидация
    if (empty($name)) {
        $errors[] = "Имя обязательно";
    }

    if (empty($email)) {
        $errors[] = "Email обязателен";
    } elseif (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        $errors[] = "Некорректный email (должен быть вида example@domain.ru)";
    }

    if (empty($phone)) {
        $errors[] = "Телефон обязателен";
    } elseif (!preg_match('/^\+?\d{10,15}$/', $phone)) {
        $errors[] = "Некорректный номер телефона (только цифры, возможно + в начале, 10–15 символов)";
    }

    if (empty($message)) {
        $errors[] = "Сообщение обязательно";
    }

    if (empty($errors)) {
        if (saveFeedback($name, $email, $phone, $message)) {
            $success = true;
        } else {
            $errors[] = "Ошибка сохранения в базу данных";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarHub — Обратная связь</title>

    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){
            m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
        })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=107004197', 'ym');

        ym(107004197, 'init', {webvisor:true, clickmap:true, trackLinks:true, accurateTrackBounce:true});
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/107004197" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
</head>

<body class="bg-light">

    <!-- Шапка -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="index.html">
                    <img src="img/logo_white.png" alt="Logo" height="30" class="me-2">
                    <span class="fw-bold text-uppercase">CarHub</span>
                </a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.html">Main</a></li>
                        <li class="nav-item"><a class="nav-link" href="list.php">List</a></li>
                        <li class="nav-item"><a class="nav-link active" href="form.php">Form</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Основной контент -->
    <main class="container my-5">
        <h2 class="text-center mb-5 fw-bold">ОБРАТНАЯ СВЯЗЬ</h2>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form method="post" id="feedbackForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Имя</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Телефон</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Сообщение</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Отправить</button>
                    </div>
                </form>

                <!-- Блок результата отправки (появляется сразу под формой) -->
                <?php if ($success): ?>
                    <div class="alert alert-success mt-4 text-center">
                        Сообщение успешно отправлено!
                    </div>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger mt-4">
                        <ul class="mb-0">
                            <?php foreach ($errors as $err): ?>
                                <li><?= htmlspecialchars($err) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Футер -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-secondary small">&copy; 2026 CarHub.</p>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>