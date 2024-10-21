// Получаем элементы
const signInBtn = document.getElementById('signInBtn');
const loginDropdown = document.getElementById('loginDropdown');

// Обрабатываем клик по кнопке "Sign In"
signInBtn.addEventListener('click', function(event) {
    event.preventDefault();  // Отключаем переход по ссылке

    // Переключаем видимость дропдауна
    if (loginDropdown.style.display === 'none' || loginDropdown.style.display === '') {
        loginDropdown.style.display = 'block';  // Показываем дропдаун
    } else {
        loginDropdown.style.display = 'none';   // Скрываем дропдаун
    }
});

// Закрываем дропдаун, если кликнули вне его области
document.addEventListener('click', function(event) {
    if (!loginDropdown.contains(event.target) && !signInBtn.contains(event.target)) {
        loginDropdown.style.display = 'none';  // Закрываем дропдаун
    }
});
