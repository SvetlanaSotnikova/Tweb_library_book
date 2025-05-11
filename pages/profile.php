<?php
session_start();
require_once __DIR__ . '/../api/bd.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user = $_SESSION['user'];

if (!isset($user['card_number'])) {
    $card_stmt = $pdo->prepare("SELECT card_number FROM library WHERE user_id = ?");
    $card_stmt->execute([$user['id']]);
    $card = $card_stmt->fetch();

    $_SESSION['user']['card_number'] = $card['card_number'] ?? null;
    $user['card_number'] = $card['card_number'] ?? null;
}

if (!isset($user['avatar'])) {
    $stmt = $pdo->prepare("SELECT avatar FROM users WHERE id = ?");
    $stmt->execute([$user['id']]);
    $row = $stmt->fetch();
    $_SESSION['user']['avatar'] = $row['avatar'] ?? null;
    $user['avatar'] = $row['avatar'] ?? null;
}


$error = '';
$success = '';

// Обработка загрузки аватара
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['avatar'])) {
    $upload_dir = __DIR__ . '/../uploads/';
    $file_name = basename($_FILES['avatar']['name']);
    $target_path = $upload_dir . $file_name;
    $avatar_url = '/uploads/' . $file_name;

    // Проверка MIME-типа
    $file_type = mime_content_type($_FILES['avatar']['tmp_name']);
    $allowed_types = ['image/jpeg', 'image/png'];

    if (!in_array($file_type, $allowed_types)) {
        $error = "Можно загружать только изображения (jpg, png).";
    } else {
        // Сохраняем файл
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_path)) {
            // Обновляем в базе
            $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
            $stmt->execute([$avatar_url, $user['id']]);

            // Загружаем обновлённые данные
            $updatedUser = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $updatedUser->execute([$user['id']]);
            $freshUser = $updatedUser->fetch();

            if ($freshUser && is_array($freshUser)) {
                $_SESSION['user'] = $freshUser;
                $user = $freshUser;

                $card_stmt = $pdo->prepare("SELECT card_number FROM library WHERE user_id = ?");
                $card_stmt->execute([$user['id']]);
                $card = $card_stmt->fetch();

                $_SESSION['user']['card_number'] = $card['card_number'] ?? null;
                $user['card_number'] = $card['card_number'] ?? null;

                $success = "Фотография успешно загружена!";
            } else {
                // если не нашли юзера — выходим
                session_destroy();
                header("Location: ../auth/login.php");
                exit;
            }

        } else {
            $error = "Ошибка при сохранении файла.";
        }
    }}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-card {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
        }
        .btn-back a.btn.btn-secondary {
            background-color: #fff;
            color           : #000;
            border-radius   : 0%;
            font-family     : var(--font-family);
            font-weight     : 700;
            font-size       : 10px;
            letter-spacing  : 0.1em;
            text-decoration : underline;
            color           : #0c0c0e;
            margin-top      : 50px;
        }

        .btn-back a.btn.btn-secondary:hover {
            background-color: #bb945f;
            color           : #000;
            border          : 1px solid #0c0c0e;
        }
        
    </style>
</head>
<body class="bg-light">
    <div class="profile-card">
        <h2>Привет, <?= htmlspecialchars($user['name'] ?? '—') ?>!</h2>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? '—') ?></p>
        <p><strong>Library Card:</strong>
            <?= isset($user['card_number']) ? htmlspecialchars($user['card_number']) : '—' ?>
        </p>

        <?php if (!empty($user['avatar'])): ?>
            <div class="mb-3">
                <img src="<?= htmlspecialchars($user['avatar'] ?? '-') ?>" alt="Avatar" class="img-thumbnail" width="150">
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="mt-3">
            <div class="mb-3">
                <label for="avatar" class="form-label">Загрузить фото:</label>
                <input type="file" name="avatar" id="avatar" class="form-control" required accept="image/jpeg,image/png">
            </div>
            <button type="submit" class="btn btn-primary">📤 Загрузить</button>
        </form>
        <div class="btn-back">
            <a href="../index.php" class="btn btn-secondary">⬅ Back</a>
        </div>
        <a href="/auth/logout.php" class="btn btn-danger mt-3">logout</a>
    </div>
</body>
</html>