<?php
require_once '../api/bd.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Некорректный или отсутствующий ID");
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM user_loved_books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    die("Книга не найдена");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];

    $stmt = $pdo->prepare("UPDATE user_loved_books SET title = ?, author = ?, genre = ? WHERE id = ?");
    $stmt->execute([$title, $author, $genre, $id]);

    header("Location: loved-books.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать книгу</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h1 class="mb-4">✏️ Редактировать книгу</h1>
    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Название</label>
            <input type="text" name="title" value="<?= $book['title'] ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Автор</label>
            <input type="text" name="author" value="<?= $book['author'] ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Жанр</label>
            <input type="text" name="genre" value="<?= $book['genre'] ?>" class="form-control">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <a href="./loved-books.php" class="btn btn-secondary">⬅ Назад</a>
        </div>
    </form>
</div>
</body>
</html>
