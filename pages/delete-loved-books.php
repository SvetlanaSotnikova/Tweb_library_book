<?php
session_start();
require_once '../api/bd.php';


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Некорректный или отсутствующий ID");
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("DELETE FROM user_loved_books WHERE id = ?");
$stmt->execute([$id]);


header("Location: ./loved-books.php");
exit;
?>
