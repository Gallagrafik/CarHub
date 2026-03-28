// ФУНКЦИИ

function loadCars() {
    const container = document.getElementById('carsContainer');
    if (!container) return;

    fetch('ajax.php')
        .then(r => r.json())
        .then(cars => updateCarsList(cars))
        .catch(err => console.error('Ошибка загрузки автомобилей:', err));
}

function updateCarsList(cars) {
    const container = document.getElementById('carsContainer');
    if (!container) {
        console.log('updateCarsList: контейнер #carsContainer не найден');
        return;
    }

    container.innerHTML = '';

    cars.forEach(car => {
        const div = document.createElement('div');
        div.className = 'col';
        div.innerHTML = `
            <div class="card h-100 border-0 shadow-sm">
                <img src="${car.image || 'img/no-image.jpg'}" class="card-img-top" alt="${car.title}">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">${car.title}</h5>
                    <p class="card-text fw-bold text-success">${Number(car.price || 0).toLocaleString()} ₽</p>
                    <p class="card-text">${(car.description || '').substring(0, 100)}...</p>
                    <a href="item.php?slug=${car.slug || ''}" class="btn btn-outline-dark btn-sm">Подробнее</a>
                </div>
            </div>`;
        container.appendChild(div);
    });
}

// ЗАЯВКИ

function loadFeedbacks() {
    fetch('ajax.php?action=get_feedbacks')
        .then(r => r.json())
        .then(feedbacks => {
            console.log("Полученные заявки:", feedbacks);   // для отладки
            updateFeedbacksList(feedbacks);
        })
        .catch(err => console.error('Ошибка загрузки заявок:', err));
}

function updateFeedbacksList(feedbacks) {
    const container = document.getElementById('feedbacksContainer');
    if (!container) return;

    container.innerHTML = '';

    if (feedbacks.length === 0) {
        container.innerHTML = '<div class="col-12"><p class="text-center text-muted">Пока нет заявок</p></div>';
        return;
    }

    feedbacks.forEach(fb => {
        const name    = fb.name     || '—';
        const phone   = fb.phone    || '—';
        const email   = fb.email    || '—';
        const message = fb.message  || '—';

        const dateStr = new Date(fb.created_at).toLocaleString('ru-RU', {
            day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit'
        });

        const html = `
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">${name}</h5>
                        <p class="card-text"><strong>Телефон:</strong> ${phone}</p>
                        <p class="card-text"><strong>Email:</strong> ${email}</p>
                        <p class="card-text"><strong>Сообщение:</strong><br>${message}</p>
                        <small class="text-muted">Отправлено: ${dateStr}</small>
                    </div>
                </div>
            </div>`;
        container.innerHTML += html;
    });
}

// ЗАГРУЗКА СТРАНИЦЫ

document.addEventListener('DOMContentLoaded', () => {

    // Страница списка автомобилей
    if (document.getElementById('carsContainer')) {
        loadCars();
        setInterval(loadCars, 10000);        // каждые 10 секунд
    }

    // Страница заявок (feedbacks.html)
    if (document.getElementById('feedbacksContainer')) {
        loadFeedbacks();
        setInterval(loadFeedbacks, 10000);   // каждые 10 секунд

        const refreshBtn = document.getElementById('refreshBtn');
        if (refreshBtn) {
            refreshBtn.addEventListener('click', loadFeedbacks);
        }
    }

    // Поиск на странице машин
    const searchInput = document.getElementById('carSearch');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const val = e.target.value.toLowerCase().trim();
            document.querySelectorAll('#carsContainer .col').forEach(card => {
                const title = card.querySelector('.card-title').innerText.toLowerCase();
                card.style.display = title.includes(val) ? 'block' : 'none';
            });
        });
    }

    // Форма обратной связи
    const form = document.getElementById('feedbackForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const data = {
                name:    document.getElementById('name').value.trim(),
                email:   document.getElementById('email').value.trim(),
                phone:   document.getElementById('phone').value.trim(),
                message: document.getElementById('message').value.trim()
            };

            if (!data.name || !data.email || !data.message || 
                !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
                alert('Проверьте введённые данные!');
                return;
            }

            fetch('ajax.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams(data)
            })
            .then(response => response.json())
            .then(res => {
                const modal = new bootstrap.Modal(document.getElementById('successModal'), {
                    backdrop: 'static',
                    keyboard: true
                });
                document.getElementById('modalMessage').innerText = 
                    res.message || (res.success ? 'Заявка успешно отправлена!' : 'Ошибка');
                modal.show();

                if (res.success) form.reset();
            })
            .catch(err => {
                console.error('Ошибка:', err);
                alert('Ошибка соединения с сервером');
            });
        });
    }
});