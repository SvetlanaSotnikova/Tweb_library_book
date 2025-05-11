<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/config.php';

use League\OAuth2\Client\Provider\Google;

$provider = new Google([
    'clientId'     => $googleClientId,
    'clientSecret' => $googleClientSecret,
    'redirectUri'  => $googleRedirectUri,
]);
    // Если это первый шаг (перенаправление на Google)
    if (!isset($_GET['code'])) {
        $authUrl = $provider->getAuthorizationUrl();
        $_SESSION['oauth2state'] = $provider->getState();
        header('Location: ' . $authUrl);
        exit;
    }

    // Обработка callback от Google
    if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
        die('Ошибка: Неверный state-параметр');
    }

    try {
        // Получаем данные пользователя
        $token = $provider->getAccessToken('authorization_code', ['code' => $_GET['code']]);
        $googleUser = $provider->getResourceOwner($token);
        $userData = $googleUser->toArray();

        // Проверяем, есть ли пользователь в БД
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$userData['email']]);
        $user = $stmt->fetch();

        if (!$user) {
            // Регистрируем нового пользователя
            $stmt = $pdo->prepare("INSERT INTO users (name, email, google_id) VALUES (?, ?, ?)");
            $stmt->execute([$userData['name'], $userData['email'], $userData['id']]);
            $userId = $pdo->lastInsertId();

            // Создаем карточку в `library`
            $cardNumber = 'LIB' . str_pad($userId, 6, '0', STR_PAD_LEFT);
            $stmt = $pdo->prepare("INSERT INTO library (user_id, card_number) VALUES (?, ?)");
            $stmt->execute([$userId, $cardNumber]);

            // Сохраняем данные в сессию
            $_SESSION['user'] = [
                'id' => $userId,
                'name' => $userData['name'],
                'email' => $userData['email'],
                'card_number' => $cardNumber
            ];
        } else {
            // Пользователь уже есть, просто авторизуем
            $_SESSION['user'] = $user;
        }

        // Перенаправляем в профиль
        header('Location: /profile.php');
        exit;
    } catch (Exception $e) {
        die("Ошибка: " . $e->getMessage());
    }

?>