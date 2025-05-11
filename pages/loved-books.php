<?php
session_start();
require_once "../api/bd.php";


if (!isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit;
}
$user_id = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT * FROM user_loved_books WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);

$rows = $stmt ->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Книжный магазин</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">📚 Список книг</h1>
    <a href="./create-loved-books.php" class="btn btn-success mb-3">➕ Добавить книгу</a>
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>Название</th><th>Автор</th><th>Жанр</th><th>Дата</th><th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($rows as $row) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['author'] ?></td>
                <td><?= $row['genre'] ?></td>
                <td><?= $row['created_at'] ?></td>
                <td>
                    <a href="./edit-loved-books.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">✏️</a>
                    <a href="delete-loved-books.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Удалить книгу?')">🗑️</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>