document.addEventListener("DOMContentLoaded", () => {
    fetch('/api/cart.php')
        .then(res => res.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                const count = data.reduce((sum, item) => sum + parseInt(item.quantity), 0);
                const badge = document.getElementById("cart-count");
                badge.innerText = count;
                badge.style.display = "inline-block";
            }
        })
        .catch(err => console.error("Failed to load cart count:", err));
});
