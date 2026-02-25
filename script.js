// Дожидаемся загрузки DOM
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('carSearch');
    
    // Проверяем, есть ли поиск на текущей странице
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const val = e.target.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.col'); // Берем все колонки с карточками

            cards.forEach(card => {
                const title = card.querySelector('.card-title').innerText.toLowerCase();
                // Если текст совпадает — показываем колонку, если нет — скрываем
                card.style.display = title.includes(val) ? 'block' : 'none';
            });
        });
        console.log("Поиск CarHub активирован.");
    }
});

// Обработка формы (ЛР №3)
const orderForm = document.getElementById('orderForm');

if (orderForm) {
    orderForm.addEventListener('submit', function(e) {
        e.preventDefault(); // 1. Отключаем перезагрузку страницы

        // Получаем данные из полей
        const name = document.getElementById('userName').value.trim();
        const phone = document.getElementById('userPhone').value.trim();
        const email = document.getElementById('userEmail').value.trim();

        // 2. Регулярные выражения для проверки
        const phoneRegex = /^\+?[0-9]{10,15}$/; // Простой формат телефона
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Стандартный email

        // Проверка данных
        if (!name) {
            alert("Введите имя!");
            return;
        }
        if (!phoneRegex.test(phone)) {
            alert("Введите корректный номер телефона (например, +79991234567)");
            return;
        }
        if (!emailRegex.test(email)) {
            alert("Введите корректный Email!");
            return;
        }

        // 3. Вывод данных в консоль (требование ЛР)
        console.log("--- Данные формы CarHub ---");
        console.log("Имя:", name);
        console.log("Телефон:", phone);
        console.log("Email:", email);

        // 4. Показываем модальное окно через Bootstrap API
        const myModal = new bootstrap.Modal(document.getElementById('successModal'));
        myModal.show();

        // Очищаем форму
        orderForm.reset();
    });
}