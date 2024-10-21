document.addEventListener('DOMContentLoaded', function() {
    const profileBtn = document.getElementById("profileBtn");
    const profileDropdown = document.getElementById("profileDropdown");
    const form = document.getElementById('profileForm');
    const fields = form.querySelectorAll('input');

// Показать или скрыть выпадающее меню при клике на кнопку
    profileBtn.addEventListener('click', (event) => {
        event.stopPropagation();
        profileDropdown.style.display = profileDropdown.style.display === "block" ? "none" : "block";
    });

    // Закрыть выпадающее меню при клике вне его
    window.addEventListener('click', (event) => {
        if (!event.target.closest('.dropdown-profile')) {
            profileDropdown.style.display = "none";
        }
    });
});