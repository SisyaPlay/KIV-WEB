document.addEventListener('DOMContentLoaded', () => {
    // Получаем элементы
    const signInBtn = document.getElementById('signInBtn');
    const loginDropdown = document.getElementById('loginDropdown');
    const form = document.getElementById('loginForm');  // Изменено на 'loginForm'
    const fields = form.querySelectorAll('input');
    const usernameField = document.getElementById('username');
    const passwordField = document.getElementById('password');
    const serverErrors = []; // Примерный массив серверных ошибок для тестирования

    // Функция для показа ошибки
    const showError = (field, message) => {
        const errorElement = document.getElementById(`${field.id}-error`);
        if (errorElement) {
            field.classList.add('error');
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        } else {
            console.error(`Element for ${field.id}-error not found`);
        }
    };

    // Функция для скрытия ошибки
    const hideError = (field) => {
        field.classList.remove('error');
        const errorElement = document.getElementById(`${field.id}-error`);
        if (errorElement) {
            errorElement.style.display = 'none';
            errorElement.textContent = '';
        }
    };

    // Обрабатываем клик по кнопке "Sign In" для показа дропдауна
    signInBtn.addEventListener('click', (event) => {
        event.preventDefault();
        loginDropdown.style.display = loginDropdown.style.display === 'block' ? 'none' : 'block';
    });

    // Закрываем дропдаун, если кликнули вне его области
    document.addEventListener('click', (event) => {
        if (!loginDropdown.contains(event.target) && !signInBtn.contains(event.target)) {
            loginDropdown.style.display = 'none';
        }
    });

    // Проверка ошибок формы и серверные ошибки
    if (serverErrors.length > 0) {
        serverErrors.forEach(error => {
            if (error.includes('Invalid password or username')) {
                showError(usernameField, error);
                showError(passwordField, error);
            }
        });
    }

    // Валидация формы при отправке
    form.addEventListener('submit', (event) => {
        let isValid = true;

        // Проверка на пустые поля
        fields.forEach((field) => {
            if (field.value.trim() === '') {
                showError(field, `${field.name} is required`);
                isValid = false;
            } else {
                hideError(field);
            }
        });

        if (!isValid) event.preventDefault();
    });

    // Убираем ошибку при вводе
    fields.forEach((field) => {
        field.addEventListener('input', () => hideError(field));
    });
});
