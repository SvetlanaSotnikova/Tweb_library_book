<?php
session_start();
require_once '../api/bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user'])) {
        die("Пользователь не залогинен");
    }
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $user_id = $_SESSION['user']['id'];

    $stmt = $pdo->prepare("INSERT INTO user_loved_books (title, author, genre, user_id) VALUES (?, ?, ?, ?)");
    $stmt->execute([$title, $author, $genre, $user_id]);

    header("Location: loved-books.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить книгу</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">➕ Добавить книгу</h1>
    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Название</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Автор</label>
            <input type="text" name="author" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Жанр</label>
            <input type="text" name="genre" class="form-control">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">Сохранить</button>
            <a href="./loved-books.php" class="btn btn-secondary">⬅ Назад</a>
        </div>
    </form>
</div>
</body>
</html>
