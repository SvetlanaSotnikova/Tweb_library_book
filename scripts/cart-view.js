document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("cart-container");
    const emptyMessage = document.getElementById("empty-message");

    fetch("/api/cart.php")
        .then(res => res.json())
        .then(data => {
            container.innerHTML = "";

            if (!Array.isArray(data) || data.length === 0) {
                emptyMessage.style.display = "block";
                return;
            }

            emptyMessage.style.display = "none";

            data.forEach(book => {
                const tr = document.createElement("tr");

                tr.innerHTML = `
                    <td><img src="${book.image}" alt="${book.title}" class="book-image img-thumbnail" style="max-width: 80px;"></td>
                    <td>
                        <strong>${book.title}</strong><br>
                        <small><em>${book.author}</em></small>
                    </td>
                    <td style="max-width: 300px;">${book.description}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center">
                            <button class="btn btn-sm btn-outline-secondary decrease-btn" data-id="${book.id}">−</button>
                            <span class="mx-2">${book.quantity}</span>
                            <button class="btn btn-sm btn-outline-secondary increase-btn" data-id="${book.id}">+</button>
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${book.id}">🗑</button>
                    </td>
                `;

                container.appendChild(tr);
            });

            // Удаление
            document.querySelectorAll(".delete-btn").forEach(btn => {
                btn.addEventListener("click", () => {
                    fetch("/api/cart.php", {
                        method: "DELETE",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: btn.dataset.id })
                    }).then(() => location.reload());
                });
            });

            // Увеличение
            document.querySelectorAll(".increase-btn").forEach(btn => {
                btn.addEventListener("click", () => {
                    const row = btn.closest("tr");
                    const quantity = parseInt(row.querySelector("span").innerText) + 1;

                    fetch("/api/cart.php", {
                        method: "PUT",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: btn.dataset.id, quantity: quantity })
                    }).then(() => location.reload());
                });
            });

            // Уменьшение
            document.querySelectorAll(".decrease-btn").forEach(btn => {
                btn.addEventListener("click", () => {
                    const row = btn.closest("tr");
                    let quantity = parseInt(row.querySelector("span").innerText);
                    if (quantity <= 1) return;

                    quantity--;

                    fetch("/api/cart.php", {
                        method: "PUT",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({ id: btn.dataset.id, quantity: quantity })
                    }).then(() => location.reload());
                });
            });
        });
});
