document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('signupForm');
    const usernameField = document.getElementById('username-');
    const passwordField = document.getElementById('password-');
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
        if (error.includes('username')) showError(usernameField, error);
        if (error.includes('password')) showError(passwordField, error);
    });

    form.addEventListener('submit', (event) => {
        let isValid = true;

        // Проверка на пустые поля
        [usernameField, passwordField].forEach((field) => {
            if (field.value.trim() === '') {
                showError(field, `${field.name} is required`);
                isValid = false;
            } else {
                hideError(field);
            }
        });

        if (!isValid) event.preventDefault();
    });

    // Удаление ошибок при вводе
    [usernameField, passwordField].forEach((field) => {
        field.addEventListener('input', () => hideError(field));
    });
});
