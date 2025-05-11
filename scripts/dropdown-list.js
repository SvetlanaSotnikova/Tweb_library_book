document.addEventListener("DOMContentLoaded", () => {
    const profileButton = document.querySelector(".profile-btn");
    const dropdownContent = document.querySelector(".dropdown-content");

    // Открытие/закрытие выпадающего меню при клике
    profileButton.addEventListener("click", (event) => {
        event.stopPropagation(); // Предотвращаем закрытие меню при клике на кнопку
        dropdownContent.classList.toggle("show");
    });

    // Закрытие меню при клике в любом месте вне меню
    document.addEventListener("click", () => {
        if (dropdownContent.classList.contains("show")) {
            dropdownContent.classList.remove("show");
        }
    });
});
