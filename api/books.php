<?php
require_once __DIR__ . '/bd.php';

header('Content-Type: application/json');

$season = $_GET['season'] ?? null;

if (!$season || !in_array($season, ['WINTER', 'SPRING', 'SUMMER', 'AUTUMN'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing season']);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM books WHERE season = ?");
$stmt->execute([$season]);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($books);
