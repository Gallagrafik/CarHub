document.addEventListener('DOMContentLoaded', () => {

    // Поиск (ЛР3)
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

    // AJAX отправка формы
    const form = document.getElementById('feedbackForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const data = {
                name: document.getElementById('name').value.trim(),
                email: document.getElementById('email').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                message: document.getElementById('message').value.trim()
            };

            // клиентская валидация
            if (!data.name || !data.email || !data.message || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
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
                const modalEl = document.getElementById('successModal');
                const modal = new bootstrap.Modal(modalEl, {
                    backdrop: 'static',     // нельзя закрыть кликом вне окна
                    keyboard: true       // можно закрыть клавишей Esc
                });

                document.getElementById('modalMessage').innerText = 
                    res.message || (res.success ? 'Заявка успешно отправлена!' : 'Произошла ошибка');

                modal.show();

                if (res.success) {
                    form.reset();
                }
            })
            .catch(err => {
                console.error('Ошибка:', err);
                document.getElementById('modalMessage').innerText = 'Ошибка соединения с сервером';
                new bootstrap.Modal(document.getElementById('successModal'), {
                    backdrop: 'static',
                    keyboard: false
                }).show();
            });
        });
    }

    // Кнопка обновления списка (ЛР5)
    const refreshBtn = document.getElementById('refreshBtn');
    if (refreshBtn) {
        refreshBtn.addEventListener('click', () => {
            fetch('ajax.php')
                .then(r => r.json())
                .then(cars => updateCarsList(cars));
        });
    }
});

function updateCarsList(cars) {
    const container = document.getElementById('carsContainer');
    container.innerHTML = '';
    cars.forEach(car => {
        const div = document.createElement('div');
        div.className = 'col';
        div.innerHTML = `
            <div class="card h-100 border-0 shadow-sm">
                <img src="${car.image || 'img/no-image.jpg'}" class="card-img-top" alt="${car.title}">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold">${car.title}</h5>
                    <p class="card-text fw-bold text-success">${Number(car.price).toLocaleString()} ₽</p>
                    <p class="card-text">${car.description.substring(0, 100)}...</p>
                    <a href="item.php?slug=${car.slug}" class="btn btn-outline-dark btn-sm">Подробнее</a>
                </div>
            </div>`;
        container.appendChild(div);
    });
}