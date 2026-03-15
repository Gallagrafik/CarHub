<?php
include 'script.php';

$slug = $_GET['slug'] ?? '';
if (!$slug) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM cars WHERE slug = ? LIMIT 1");
$stmt->execute([$slug]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    echo '<h1 class="text-center mt-5">Автомобиль не найден</h1>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarHub — <?= htmlspecialchars($car['title']) ?></title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="index.html">
                    <img src="img/logo_white.png" alt="Logo" height="30" class="me-2">
                    <span class="fw-bold text-uppercase">CarHub</span>
                </a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.html">Главная</a></li>
                        <li class="nav-item"><a class="nav-link" href="list.php">Каталог</a></li>
                        <li class="nav-item"><a class="nav-link" href="form.php">Обратная связь</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        <div class="row">
            <!-- Фото -->
            <div class="col-lg-6 mb-4">
                <img src="<?= htmlspecialchars($car['image']) ?>" 
                     class="img-fluid rounded shadow-lg" 
                     alt="<?= htmlspecialchars($car['title']) ?>">
            </div>

            <!-- Информация -->
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold"><?= htmlspecialchars($car['title']) ?></h1>
                <p class="fs-2 text-success fw-bold"><?= number_format($car['price'], 0, ' ', ' ') ?> ₽</p>

                <!-- Характеристики (отдельные ячейки) -->
                <div class="row g-3 mt-4">
                    <div class="col-6 col-md-4">
                        <div class="border rounded p-3 text-center bg-white shadow-sm">
                            <strong>Мощность</strong><br>
                            <span class="fs-4"><?= $car['power'] ?> л.с.</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="border rounded p-3 text-center bg-white shadow-sm">
                            <strong>Макс. скорость</strong><br>
                            <span class="fs-4"><?= $car['top_speed'] ?> км/ч</span>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="border rounded p-3 text-center bg-white shadow-sm">
                            <strong>0–100 км/ч</strong><br>
                            <span class="fs-4"><?= $car['acceleration'] ?> сек</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="border rounded p-3 bg-white shadow-sm">
                            <strong>Двигатель</strong><br>
                            <span class="fs-5"><?= htmlspecialchars($car['engine_type']) ?></span>
                        </div>
                    </div>
                </div>

                <!-- Полное описание -->
                <div class="mt-5">
                    <h4>Подробное описание</h4>
                    <p class="lead"><?= nl2br(htmlspecialchars($car['description'])) ?></p>
                </div>

                <a href="form.php" class="btn btn-primary btn-lg mt-4">Оставить заявку на этот автомобиль</a>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-secondary small">© 2026 CarHub.</p>
        </div>
    </footer>

    <?php include 'metrika.php'; ?>
</body>
</html>