const images = JSON.parse(document.getElementById("gallery-data").textContent);
let currentIndex = 0;

// Функция для открытия модального окна с изображением
function openModal(index) {
    currentIndex = index;
    const modal = document.getElementById("modal");
    const modalImg = document.getElementById("modal-image");
    modal.style.display = "block";
    modalImg.src = images[currentIndex];
}

// Функция для закрытия модального окна
function closeModal() {
    const modal = document.getElementById("modal");
    modal.style.display = "none";
}

// Функция для переключения изображений
function changeImage(direction) {
    currentIndex = (currentIndex + direction + images.length) % images.length;
    document.getElementById("modal-image").src = images[currentIndex];
}

// Закрытие модального окна при клике вне изображения
window.onclick = function(event) {
    const modal = document.getElementById("modal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
