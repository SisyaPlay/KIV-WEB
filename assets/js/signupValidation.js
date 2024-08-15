document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('signupForm');
    const fields = form.querySelectorAll('input');
    const passwordField = document.getElementById('password');
    const passwordConfirmField = document.getElementById('password_comfirm');
    const serverErrors = JSON.parse(document.getElementById('server-errors').textContent);

    const showError = (field, message) => {
        const errorElement = document.getElementById(`${field.id}-error`);
        field.classList.add('error');
        errorElement.textContent = message;
        errorElement.style.display = 'block';

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
        errorElement.style.display = 'none';
        const exclamationMark = field.parentNode.querySelector('.exclamation');
        if (exclamationMark) exclamationMark.remove();
    };

    // Отображение серверных ошибок
    if (serverErrors.length > 0) {
        serverErrors.forEach(error => {
            if (error.includes('Username already exists')) {
                const usernameField = document.getElementById('username');
                showError(usernameField, error);
            }
        });
    }

    form.addEventListener('submit', (event) => {
        let isValid = true;

        fields.forEach((field) => {
            if (field.value.trim() === '') {
                showError(field, `${field.name.charAt(0).toUpperCase() + field.name.slice(1)} is required`);
                isValid = false;
            } else {
                hideError(field);
            }
        });

        // Проверяем, совпадают ли пароли
        if (passwordField.value !== passwordConfirmField.value) {
            showError(passwordConfirmField, 'Passwords do not match');
            isValid = false;
        } else if (passwordConfirmField.value === '') {
            showError(passwordConfirmField, 'Password confirmation is required');
            isValid = false;
        }

        if (!isValid) event.preventDefault();
    });

    fields.forEach((field) => {
        field.addEventListener('input', () => hideError(field));
    });
});
