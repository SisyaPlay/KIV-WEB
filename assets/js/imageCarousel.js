let currentIndex = 0;
const items = document.querySelectorAll('.carousel-item');
const thumbnails = document.querySelectorAll('.thumbnail');
const totalItems = items.length;
let carouselInterval;

function showImage(index) {
    items[currentIndex].style.display = 'none'; // Скрыть текущее изображение
    currentIndex = index; // Установить новый индекс
    items[currentIndex].style.display = 'block'; // Показать новое изображение

    // Обновить стиль миниатюр
    thumbnails.forEach((thumbnail) => {
        thumbnail.classList.remove('active'); // Удалить активный класс у всех
        const thumbnailIndex = parseInt(thumbnail.getAttribute('data-index'));
        if (thumbnailIndex === currentIndex) {
            thumbnail.classList.add('active'); // Добавить класс активной миниатюре
        }
    });
}

function showNextImage() {
    showImage((currentIndex + 1) % totalItems); // Показать следующее изображение
}

function startCarousel() {
    carouselInterval = setInterval(showNextImage, 3000); // Смена изображения каждые 3 секунды
}

// Скрыть все изображения, кроме первого
items.forEach((item, index) => {
    item.style.display = index === 0 ? 'block' : 'none';
});

// Запустить карусель
startCarousel();

// Добавить обработчики событий для миниатюр
thumbnails.forEach((thumbnail) => {
    thumbnail.addEventListener('click', () => {
        const index = parseInt(thumbnail.getAttribute('data-index'));
        showImage(index); // Показать выбранное изображение
        clearInterval(carouselInterval); // Остановить таймер
        startCarousel(); // Перезапустить таймер
    });
});
