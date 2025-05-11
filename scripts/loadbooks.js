document.addEventListener("DOMContentLoaded", function () {
    const seasonRadios = document.querySelectorAll('input[name="favorites_season"]');

    // 🛎 Показ тоста
    function showBookToast(message, type = 'success') {
        const toastEl = document.getElementById('book-toast');
        const toastBody = document.getElementById('toast-message');

        toastBody.innerHTML = message;
        toastEl.className = `toast align-items-center text-bg-${type} border-0`;

        const toast = new bootstrap.Toast(toastEl);
        toast.show();
    }

    // Загрузка книг по сезону
    function loadBooks(season) {
        fetch(`/api/books.php?season=${season}`)
            .then(res => res.json())
            .then(books => {
                document.querySelectorAll('.season-block').forEach(el => el.style.display = "none");
                const blockId = `block-${season.toLowerCase()}`;
                const container = document.getElementById(blockId);
                const cardsWrapper = container.querySelector(".cards-books");
                cardsWrapper.innerHTML = "";

                books.forEach(book => {
                    const card = document.createElement("div");
                    const descriptionSafe = (book.description || "").replace(/"/g, '&quot;');
                    card.classList.add("card");
                    card.style.width = "18rem";

                    card.innerHTML = `
                        <img src="${book.image}" class="card-img-top" alt="${book.title}">
                        <div class="card-body">
                            <h5 class="card-title">${book.title} <br> By ${book.author}</h5>
                            <p class="card-text">${book.description || ""}</p>
                            <p class="card-text"><strong>Price:</strong> $${book.price}</p>
                            <button class="btn btn-primary buy-button" 
                                    data-id="${book.id}" 
                                    data-title="${book.title}" 
                                    data-author="${book.author}" 
                                    data-image="${book.image}"
                                    data-description="${descriptionSafe}">
                                Buy
                            </button>
                        </div>
                    `;
                    cardsWrapper.appendChild(card);
                });

                container.style.display = "block";

                // Обработка кликов по "Buy"
                document.querySelectorAll(".buy-button").forEach(btn => {
                    btn.addEventListener("click", () => {
                        const data = {
                            book_id: btn.dataset.id,
                            title: btn.dataset.title,
                            author: btn.dataset.author,
                            image: btn.dataset.image,
                            description: btn.dataset.description || ""
                        };

                        fetch('/api/cart.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify(data)
                        })
                            .then(res => res.json())
                            .then(response => {
                                if (response.success) {
                                    showBookToast(`📚 Book added to cart! <a href="/pages/cart-view.php" class="text-white ms-2 text-decoration-underline">View cart</a>`);
                                } else {
                                    showBookToast("⚠️ Error: " + response.error, 'danger');
                                }
                            })
                            .catch(err => {
                                console.error("Cart error:", err);
                                showBookToast("⚠️ Could not add book to cart.", 'danger');
                            });
                    });
                });
            })
            .catch(error => {
                console.error("Error loading books:", error);
            });
    }

    const defaultSeason = document.querySelector('input[name="favorites_season"]:checked')?.value || "WINTER";
    loadBooks(defaultSeason);

    seasonRadios.forEach(radio => {
        radio.addEventListener("change", () => {
            loadBooks(radio.value);
        });
    });
});
