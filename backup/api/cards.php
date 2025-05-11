<?php
header("Content-Type: application/json");
require_once "./bd.php";

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["card_number"]) || !isset($data["card_name"])) {
    echo json_encode(["error" => " card number is reqierd!"]);
    exit;
}

$cardNumber = trim($data["card_number"]);
$cardName = trim($data["card_name"]);
if (!isset($pdo)) {
    die(json_encode(["error" => "Database connection is not established."]));
}
$query = $pdo->prepare("select * from library where card_number = :card_number and name = :name");
$params = [
    "card_number" => $cardNumber,
    "name" => $cardName
];

$query->execute($params);
$card = $query->fetch();

if ($card) {
    echo json_encode(["card_number" => $card]);

} else {
    http_response_code(404);
    echo json_encode(["message" => "Карта не найдена :("]);
}

?>