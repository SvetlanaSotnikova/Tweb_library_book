<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

// Включите отладку
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $provider = new Google([
        'clientId'     => $googleClientId,
        'clientSecret' => $googleClientSecret,
        'redirectUri'  => $googleRedirectUri,
    ]);

    if (!isset($_GET['code'])) {
        $authUrl = $provider->getAuthorizationUrl();
        $_SESSION['oauth2state'] = $provider->getState();
        header('Location: ' . $authUrl);
        exit;
    }

    // Проверка state
    if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
        die('Invalid state parameter');
    }

    // Получаем токен
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Получаем данные пользователя
    $user = $provider->getResourceOwner($token);
    $userData = $user->toArray();

    // Отладка - посмотрите какие данные приходят
    echo "<pre>User data from Google:";
    print_r($userData);
    echo "</pre>";

    // Проверяем есть ли пользователь в БД
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$userData['email']]);
    $existingUser = $stmt->fetch();

    if (!$existingUser) {
        // Регистрируем нового
        $stmt = $pdo->prepare("INSERT INTO users (name, email, google_id) VALUES (?, ?, ?)");
        $stmt->execute([$userData['name'], $userData['email'], $userData['id']]);
        $userId = $pdo->lastInsertId();

        // Создаем карточку
        $cardNumber = 'LIB' . str_pad($userId, 6, '0', STR_PAD_LEFT);
        $stmt = $pdo->prepare("INSERT INTO library (user_id, card_number) VALUES (?, ?)");
        $stmt->execute([$userId, $cardNumber]);
    } else {
        $userId = $existingUser['id'];
        $cardNumber = $existingUser['card_number'] ?? null;
    }

    // Сохраняем в сессию
    $_SESSION['user'] = [
        'id' => $userId,
        'name' => $userData['name'],
        'email' => $userData['email'],
        'card_number' => $cardNumber
    ];

    // Отладка сессии
    echo "<pre>Session data:";
    print_r($_SESSION);
    echo "</pre>";

    // Перенаправляем
    header('Location: /profile.php');
    exit;

} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}