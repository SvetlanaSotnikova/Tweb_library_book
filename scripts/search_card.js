document.getElementById("searchBtn").addEventListener("click", async () => {
    const cardNumber = document.getElementById("card_number").value;
    const cardName = document.getElementById("card_name").value;
    const alertPlaceholder = document.getElementById("liveAlertPlaceholder");

    alertPlaceholder.innerHTML = ""; // Очищаем старые алерты


    if (!cardNumber) {
        showAlert("Введите номер карты!", "warning");
        return;
    }

    if (!cardName) {
        showAlert("Введите имя владельца!", "warning");
        return;
    }

    try {
        const response = await fetch("../api/cards.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ card_number: cardNumber, card_name: cardName })
        });

        const data = await response.json();

        if (response.ok) {
            showAlert(`Карта найдена! У вас есть скидка!`, "success");
        } else {
            showAlert(`Увы, ${data.message || "Карта не найдена"}`, "danger");
        }
    } catch (error) {
        showAlert("Ошибка сервера!", "danger");
    }
});

function showAlert(message, type) {
    const alertPlaceholder = document.getElementById("liveAlertPlaceholder");
    const wrapper = document.createElement("div");
    wrapper.innerHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    alertPlaceholder.append(wrapper);
}
