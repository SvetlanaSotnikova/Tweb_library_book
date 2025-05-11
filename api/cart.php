<?php
session_start();

require_once __DIR__ . '/bd.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {    
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user']['id'];
$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
        $stmt->execute([$user_id]);
        echo json_encode($stmt->fetchAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['title'], $data['author'], $data['image'], $data['book_id'], $data['description'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            exit;
        }

        // проверяем если товар уже есть
        $check = $pdo->prepare("SELECT id, quantity FROM cart WHERE user_id = ? AND book_id = ?");
        $check->execute([$user_id, $data['book_id']]);
        $existing = $check->fetch();

        if ($existing) {
            // Если уже есть — увеличиваем количество
            $newQty = $existing['quantity'] + 1;
            $update = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $update->execute([$newQty, $existing['id']]);

        echo json_encode(['success' => 'Quantity updated']);
        } else {
            // Если нет — добавляем новую запись
            $stmt = $pdo->prepare("INSERT INTO cart (user_id, title, author, image, book_id, description, quantity) VALUES (?, ?, ?, ?, ?, ?, 1)");
            $stmt->execute([$user_id, $data['title'], $data['author'], $data['image'], $data['book_id'], $data['description']]);

            echo json_encode(['success' => 'Book added to cart']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID is required']);
            exit;
        }
        $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
        $stmt->execute([$data['id'], $user_id]);
        echo json_encode(['success' => 'Book removed from cart']);
        break;
        
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['id'], $data['quantity'])) {
            http_response_code(400);
            echo json_encode(['error' => 'ID and quantity are required']);
            exit;
        }
    
        $quantity = max(1, intval($data['quantity'])); // нельзя меньше 1
    
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$quantity, $data['id'], $user_id]);
    
        echo json_encode(['success' => 'Quantity updated']);
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}