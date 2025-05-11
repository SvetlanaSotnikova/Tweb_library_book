<?php
session_start();
require_once '../api/bd.php';

if (isset($_SESSION['user'])) {
    header('Location: ../pages/profile.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Загружаем card_number по user_id
        $card_stmt = $pdo->prepare("SELECT card_number FROM library WHERE user_id = ?");
        $card_stmt->execute([$user['id']]);
        $card = $card_stmt->fetch();

        // Создаём сессию
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'card_number' => $card['card_number'] ?? null
        ];

        header("Location: ../pages/profile.php");
        exit;
    } else {
        $error = "Неверный email или пароль.";
    }
}
?>


<!-- HTML -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body class="bg-light">
<div class="container mt-5">
<div class="login-form-container">
    <div class="main-form">
    <h2 class="mb-4">Login</h2>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label>E-mail</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Log in</button>
        <div class="flex-line">
            <p>Don’t have an account?</p>
            <a href="register.php" class="btn btn-link">Register</a>
        </div>
        <div class="btn-back">
            <a href="../index.php" class="btn btn-secondary">⬅ Back</a>
        </div>
    </form>
    </div>
    </div>
</div>
</body>
</html>
