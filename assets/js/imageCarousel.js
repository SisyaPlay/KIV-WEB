let currentIndex = 0;
const items = document.querySelectorAll('.carousel-item');
const thumbnails = document.querySelectorAll('.thumbnail');
const totalItems = items.length;
let carouselInterval;

function showImage(index) {
    // Скрываем текущее изображение
    items[currentIndex].style.display = 'none';
    items[currentIndex].classList.remove('fade-in');

    // Устанавливаем новый индекс
    currentIndex = index;

    // Показываем новое изображение
    items[currentIndex].style.display = 'block';
    items[currentIndex].classList.add('fade-in');

    // Обновляем активное состояние миниатюр
    thumbnails.forEach((thumbnail, i) => {
        if (i === currentIndex) {
            thumbnail.classList.add('active');
        } else {
            thumbnail.classList.remove('active');
        }
    });
}

function showNextImage() {
    const nextIndex = (currentIndex + 1) % totalItems;
    showImage(nextIndex);
}

function startCarousel() {
    carouselInterval = setInterval(showNextImage, 5000); // Смена каждые 5 секунд
}

function stopCarousel() {
    clearInterval(carouselInterval);
}

// Устанавливаем начальное состояние
items.forEach((item, index) => {
    item.style.display = index === 0 ? 'block' : 'none'; // Показываем только первое изображение
});
items[0].classList.add('fade-in'); // Применяем анимацию для первого изображения
thumbnails[0].classList.add('active'); // Делаем первую миниатюру активной

// Запускаем карусель
startCarousel();

// Добавляем обработчики событий для миниатюр
thumbnails.forEach((thumbnail, index) => {
    thumbnail.addEventListener('click', () => {
        stopCarousel(); // Останавливаем автоматическую смену при клике
        showImage(index); // Показываем выбранное изображение
        startCarousel(); // Перезапускаем карусель после выбора
    });
});
