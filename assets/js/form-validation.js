// main.js

document.getElementById('signup-form').addEventListener('submit', function (event) {
    const username = document.getElementById('username');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_comfirm');

    let hasError = false;

    // Сброс предыдущих ошибок
    [username, email, password, passwordConfirm].forEach(input => {
        input.parentElement.classList.remove('error');
    });

    if (username.value === '') {
        hasError = true;
        username.parentElement.classList.add('error');
    }

    if (email.value === '') {
        hasError = true;
        email.parentElement.classList.add('error');
    }

    if (password.value === '') {
        hasError = true;
        password.parentElement.classList.add('error');
    }

    if (passwordConfirm.value === '') {
        hasError = true;
        passwordConfirm.parentElement.classList.add('error');
    }

    if (password.value !== passwordConfirm.value) {
        hasError = true;
        passwordConfirm.parentElement.classList.add('error');
        document.getElementById('password_comfirm-error').textContent = 'Passwords do not match';
    }

    if (hasError) {
        event.preventDefault(); // Предотвратить отправку формы, если есть ошибки
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const errors = JSON.parse(document.getElementById('server-errors').textContent || '[]');

    if (errors.length > 0) {
        errors.forEach(error => {
            const inputId = error.toLowerCase().split(' ')[0]; // Получаем название поля из сообщения об ошибке
            const inputElement = document.getElementById(inputId);

            if (inputElement) {
                inputElement.parentElement.classList.add('error');
                document.getElementById(`${inputId}-error`).textContent = error;
            }
        });
    }
});
