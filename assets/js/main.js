document.addEventListener("DOMContentLoaded", function() {
    // Получить элементы
    var loginBtn = document.getElementById("loginBtn");
    var loginDropdown = document.getElementById("loginDropdown");

    // Показать или скрыть выпадающее меню при клике на кнопку
    loginBtn.onclick = function(event) {
        event.stopPropagation(); // Предотвратить закрытие при клике на кнопку
        if (loginDropdown.style.display === "block") {
            loginDropdown.style.display = "none";
        } else {
            loginDropdown.style.display = "block";
        }
    }

    // Закрыть выпадающее меню при клике вне его
    window.onclick = function(event) {
        if (!event.target.closest('.dropdown')) {
            loginDropdown.style.display = "none";
        }
    }
});

// Анимация окна "Зарегистрирован"
window.onload = function() {
    var messageElement = document.getElementById('sessionMessage');
    if (messageElement) {
        setTimeout(function() {
            messageElement.style.display = 'none';
        }, 3000);
    }
};