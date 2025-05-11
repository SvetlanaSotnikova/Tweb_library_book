document.getElementById("contact-form").addEventListener("submit", (event) => {
    event.preventDefault(); // Предотвращаем отправку формы

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const message = document.getElementById("message").value.trim();
    const formMessage = document.getElementById("form-message");

    // Простая валидация
    if (!name || !email || !message) {
        formMessage.textContent = "All fields are required.";
        return;
    }

    // Проверка email
    const emailPattern = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    if (!emailPattern.test(email)) {
        formMessage.textContent = "Please enter a valid email.";
        return;
    }

    formMessage.style.color = "green";
    formMessage.textContent = "Form submitted successfully!";
    event.target.reset(); // Сбрасываем форму
});
