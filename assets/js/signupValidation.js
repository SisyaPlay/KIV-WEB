document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('signupForm');
    const fields = form.querySelectorAll('input');

    form.addEventListener('submit', function (event) {
        let isValid = true;

        fields.forEach(function (field) {
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

                errorElement.style.display = 'block';
                isValid = false;
            } else {
                field.classList.remove('error');
                errorElement.style.display = 'none';

                // Удаляем восклицательный знак, если поле заполнено
                const exclamationMark = field.parentNode.querySelector('.exclamation');
                if (exclamationMark) {
                    exclamationMark.remove();
                }
            }
        });

        if (!isValid) {
            event.preventDefault();
        }
    });

    // Убираем ошибку при вводе текста в поле
    fields.forEach(function (field) {
        field.addEventListener('input', function () {
            if (field.classList.contains('error')) {
                field.classList.remove('error');
                const exclamationMark = field.parentNode.querySelector('.exclamation');
                if (exclamationMark) {
                    exclamationMark.remove();
                }
                const errorElement = document.getElementById(field.id + '-error');
                errorElement.style.display = 'none';
            }
        });
    });
});
