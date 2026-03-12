<?php
include 'script.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Базовая настройка документа: кодировка и адаптивная область просмотра -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarHub — Список авто</title>
    
    <!-- Фавикон и стили проекта -->
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

        ym(107004197, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/107004197" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
</head>

<body class="bg-light">

    <!-- ШАПКА: Стандартное меню навигации, общее для всех страниц -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="index.html">
                    <img src="img/logo_white.png" alt="Logo" height="30" class="me-2">
                    <span class="fw-bold text-uppercase">CarHub</span>
                </a>
                <!-- Навигационные ссылки с выделением активного пункта (List) -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.html">Main</a></li>
                        <li class="nav-item"><a class="nav-link active" href="list.php">List</a></li>
                        <li class="nav-item"><a class="nav-link" href="form.php">Form</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- СПИСОК ДАННЫХ: Реализация каталога автомобилей через карточки (Bootstrap Cards) -->
    <main class="container my-5">
        <h2 class="text-center mb-5 fw-bold">НАШ АВТОПАРК</h2>
        <!-- Живой поиск для ЛР №3 -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-6 text-center">
                <input type="text" id="carSearch" class="form-control form-control-lg border-dark shadow-sm" placeholder="Введите название машины...">
                <p class="text-muted small mt-2">Поиск фильтрует список в реальном времени</p>
            </div>
        </div>

        <!-- Сетка: 1 колонка на мобильных, 3 колонки на средних экранах (row-cols-md-3) -->
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $cars = getCars();
            if (empty($cars)) {
                echo '<div class="col-12 text-center"><p class="alert alert-info">Автомобили пока не добавлены в базу данных.</p></div>';
            } else {
                foreach ($cars as $car) {
            ?>
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden">
                            <img src="<?= htmlspecialchars($car['image'] ?? 'img/no-image.jpg') ?>" class="card-img-top" alt="<?= htmlspecialchars($car['title']) ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold"><?= htmlspecialchars($car['title']) ?></h5>
                                <p class="card-text fw-bold text-success"><?= number_format($car['price'], 0, '.', ' ') ?> ₽</p>
                                <p class="card-text"><?= htmlspecialchars(substr($car['description'] ?? '', 0, 100)) ?>...</p>
                                <a href="item-<?= htmlspecialchars($car['slug']) ?>.html" class="btn btn-outline-dark btn-sm px-4">Детали</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </main>

    <!-- ПОДВАЛ: Копирайт и информационный блок -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0 text-secondary small">&copy; 2026 CarHub.</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
