document.addEventListener("DOMContentLoaded", () => {
    const loginBtn = document.getElementById("loginBtn");
    const loginDropdown = document.getElementById("loginDropdown");
    const form = document.getElementById('loginForm');
    const fields = form.querySelectorAll('input');

    // Показать или скрыть выпадающее меню при клике на кнопку
    loginBtn.addEventListener('click', (event) => {
        event.stopPropagation();
        loginDropdown.style.display = loginDropdown.style.display === "block" ? "none" : "block";
    });

    // Закрыть выпадающее меню при клике вне его
    window.addEventListener('click', (event) => {
        if (!event.target.closest('.dropdown-login')) {
            loginDropdown.style.display = "none";
        }
    });

    const showError = (field, message) => {
        const errorElement = document.getElementById(`${field.id}-error`);
        field.classList.add('error');
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
        if (!field.parentNode.querySelector('.exclamation')) {
            const exclamation = document.createElement('span');
            exclamation.classList.add('exclamation');
            exclamation.textContent = '!';
            field.parentNode.appendChild(exclamation);
        }
    };

    const hideError = (field) => {
        field.classList.remove('error');
        const errorElement = document.getElementById(`${field.id}-error`);
        if (errorElement) errorElement.style.display = 'none';
        const exclamationMark = field.parentNode.querySelector('.exclamation');
        if (exclamationMark) exclamationMark.remove();
    };

    // Валидация формы при отправке
    form.addEventListener('submit', (event) => {
        let isValid = true;

        fields.forEach(field => {
            if (field.value.trim() === '') {
                showError(field, `${field.name.charAt(0).toUpperCase() + field.name.slice(1)} is required`);
                isValid = false;
            } else {
                hideError(field);
            }
        });

        if (!isValid) {
            event.preventDefault();
            loginDropdown.style.display = 'block';
        }
    });

    // Убираем ошибку при вводе текста в поле
    fields.forEach(field => {
        field.addEventListener('input', () => hideError(field));
    });
});

// Анимация окна "Зарегистрирован"
window.onload = () => {
    const messageElement = document.getElementById('sessionMessage');
    if (messageElement) {
        setTimeout(() => messageElement.style.display = 'none', 3000);
    }
};

document.getElementById('logoutBtn').addEventListener('click', function() {
    // Создаем форму
    const form = document.createElement('form');
    form.method = 'post';
    form.action = 'vendor/logout.php';

    // Добавляем форму в DOM и отправляем
    document.body.appendChild(form);
    form.submit();
});