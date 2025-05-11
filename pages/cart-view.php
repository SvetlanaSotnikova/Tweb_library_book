<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        img.book-image {
            max-width: 80px;
            height: auto;
        }
        td {
            vertical-align: middle !important;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">🛒 Your Cart</h2>
        <div id="empty-message" class="alert alert-info text-center" style="display: none;">
            Your cart is empty.
        </div>
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Book</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cart-container">
                    <!-- JS заполнит -->
                </tbody>
            </table>
        </div>
        <a href="../index.php" class="btn btn-secondary mt-3">⬅ Back</a>
    </div>

    <script src="/scripts/cart-view.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
