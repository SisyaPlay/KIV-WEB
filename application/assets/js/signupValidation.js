document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('signupForm');
    const usernameField = document.getElementById('username-');
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password-');
    const passwordConfirmField = document.getElementById('password_confirm');
    const serverErrors = JSON.parse(document.getElementById('server-errors')?.textContent || '[]');

    const showError = (field, message) => {
        const errorElement = document.getElementById(`${field.id}-error`);
        if (errorElement) {
            field.classList.add('error');
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
    };

    const hideError = (field) => {
        field.classList.remove('error');
        const errorElement = document.getElementById(`${field.id}-error`);
        if (errorElement) {
            errorElement.style.display = 'none';
            errorElement.textContent = '';
        }
    };

    // Отображение серверных ошибок
    serverErrors.forEach(error => {
        if (error.includes('Username')) showError(usernameField, error);
        if (error.includes('Email')) showError(emailField, error);
    });

    form.addEventListener('submit', (event) => {
        let isValid = true;

        // Проверка на пустые поля
        [usernameField, emailField, passwordField, passwordConfirmField].forEach((field) => {
            if (field.value.trim() === '') {
                showError(field, `${field.name} is required`);
                isValid = false;
            } else {
                hideError(field);
            }
        });

        // Проверка на совпадение паролей
        if (passwordField.value !== passwordConfirmField.value) {
            showError(passwordConfirmField, 'Passwords do not match');
            isValid = false;
        } else if (passwordField.value && passwordConfirmField.value) {
            hideError(passwordConfirmField);
        }

        if (!isValid) event.preventDefault();
    });

    // Скрытие ошибок при вводе
    [usernameField, emailField, passwordField, passwordConfirmField].forEach((field) => {
        field.addEventListener('input', () => hideError(field));
    });
});
