document.addEventListener('DOMContentLoaded', function () {
    // Добавляем обработчик событий для кнопки отправки комментария
    document.getElementById('submitComment').addEventListener('click', function (event) {
        event.preventDefault();

        const articleId = document.getElementById('article_id').value; // ID статьи
        const content = document.getElementById('commentContent').value.trim(); // Текст комментария

        if (content) {
            fetch('/add_comment', { // Указываем корректный маршрут
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `article_id=${encodeURIComponent(articleId)}&content=${encodeURIComponent(content)}`
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Ошибка при отправке комментария');
                    }
                    return response.text();
                })
                .then(() => {
                    // Перезагружаем страницу, чтобы отобразить новый комментарий
                    window.location.href = `/article_detail?id=${articleId}`;
                })
                .catch(error => console.error('Error:', error));
        } else {
            alert('Введите текст комментария');
        }
    });
});

function showReplyBox(button) {
    // Закрываем все открытые текстовые поля для ответов
    const allContainers = document.querySelectorAll('.reply-container');
    allContainers.forEach(container => {
        container.style.display = 'none'; // Скрываем все контейнеры
    });

    // Получаем родительский элемент (div) с комментариями
    const commentDiv = button.parentElement;

    // Находим контейнер ответа в текущем комментарии
    const replyContainer = commentDiv.querySelector('.reply-container');

    // Показываем контейнер ответа
    replyContainer.style.display = 'flex'; // Показываем контейнер для ответа

    // Находим текстовое поле и кнопку отправки в текущем контейнере
    const textarea = replyContainer.querySelector('.reply-textarea');
    const submitButton = replyContainer.querySelector('.submit-reply');

    // Показываем текстовое поле и кнопку отправки, скрываем кнопку ответа
    textarea.style.display = 'block';
    submitButton.style.display = 'inline';
    button.style.display = 'none'; // Скрываем текущую кнопку "Ответить"

    // Добавляем обработчик события для изменения высоты текстового поля
    textarea.addEventListener('input', function() {
        autoResizeTextarea(textarea);
    });
}


function submitReply(button, parentId) {
    const commentDiv = button.parentElement; // Получаем родительский div
    const textarea = commentDiv.querySelector('.reply-textarea');

    const content = textarea.value; // Получаем текст комментария
    const articleId = document.getElementById('article_id').value; // Получаем ID статьи

    // Отправка комментария на сервер
    if (content) {
        fetch('/add_comment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `article_id=${encodeURIComponent(articleId)}&parent_id=${encodeURIComponent(parentId)}&content=${encodeURIComponent(content)}`
        })
            .then(response => response.text())
            .then(data => {
                // Перезагружаем страницу, чтобы отобразить новый комментарий
                window.location.href = `/article_detail?id=${articleId}`;
            })
            .catch(error => console.error('Error:', error));
    } else {
        alert('Введите текст комментария');
    }
}

function autoResizeTextarea(textarea) {
    textarea.style.height = 'auto'; // Сначала сбрасываем высоту
    textarea.style.height = (textarea.scrollHeight) + 'px'; // Устанавливаем высоту в соответствии с содержимым
}
