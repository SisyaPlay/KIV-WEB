document.addEventListener("DOMContentLoaded", function() {
    // Получить элементы
    var loginBtn = document.getElementById("loginBtn");
    var loginDropdown = document.getElementById("loginDropdown");
    const form = document.getElementById('loginForm');
    const fields = form.querySelectorAll('input');

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

    // Валидация формы при отправке
    form.addEventListener('submit', function(event) {
        let isValid = true;

        fields.forEach(function(field) {
            const errorElement = document.getElementById(field.id + '-error');
            const exclamation = document.createElement('span');
            exclamation.classList.add('exclamation');
            exclamation.textContent = '!';

            // Если поле пустое, показываем ошибку
            if (field.value.trim() === '') {
                field.classList.add('error');

                // Проверяем, добавлен ли восклицательный знак, если нет, то добавляем
                if (!field.parentNode.querySelector('.exclamation')) {
                    field.parentNode.appendChild(exclamation);
                }

                if (errorElement) {
                    errorElement.style.display = 'block';
                }
                isValid = false;
            } else {
                field.classList.remove('error');
                if (errorElement) {
                    errorElement.style.display = 'none';
                }

                // Удаляем восклицательный знак, если поле заполнено
                const exclamationMark = field.parentNode.querySelector('.exclamation');
                if (exclamationMark) {
                    exclamationMark.remove();
                }
            }
        });

        if (!isValid) {
            event.preventDefault();
            // Оставляем дропдаун меню открытым, если форма невалидна
            loginDropdown.style.display = 'block';
        }
    });

    // Убираем ошибку при вводе текста в поле
    fields.forEach(function(field) {
        field.addEventListener('input', function() {
            if (field.classList.contains('error')) {
                field.classList.remove('error');
                const exclamationMark = field.parentNode.querySelector('.exclamation');
                if (exclamationMark) {
                    exclamationMark.remove();
                }
                const errorElement = document.getElementById(field.id + '-error');
                if (errorElement) {
                    errorElement.style.display = 'none';
                }
            }
        });
    });
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
