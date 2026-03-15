<?php include 'script.php'; ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarHub — Каталог</title>
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
        <h2 class="text-center mb-5 fw-bold">НАШ АВТОПАРК</h2>

        <div class="row justify-content-center mb-4">
            <div class="col-md-6">
                <input type="text" id="carSearch" class="form-control form-control-lg" placeholder="Поиск по названию...">
            </div>
        </div>

        <button id="refreshBtn" class="btn btn-outline-secondary mb-4">Обновить список (AJAX)</button>

        <div class="row row-cols-1 row-cols-md-3 g-4" id="carsContainer">
            <?php
            $cars = getCars();
            foreach ($cars as $car) { ?>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm">
                        <img src="<?= htmlspecialchars($car['image'] ?? 'img/no-image.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($car['title']) ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($car['title']) ?></h5>
                            <p class="card-text fw-bold text-success"><?= number_format($car['price'], 0, '.', ' ') ?> ₽</p>
                            <p class="card-text"><?= htmlspecialchars(substr($car['description'] ?? '', 0, 100)) ?>...</p>
                            <a href="item.php?slug=<?= htmlspecialchars($car['slug']) ?>" class="btn btn-outline-dark btn-sm">Подробнее</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-secondary small">&copy; 2026 CarHub.</p>
        </div>
    </footer>

    <?php include 'metrika.php'; ?>
    <script src="script.js"></script>
</body>
</html>