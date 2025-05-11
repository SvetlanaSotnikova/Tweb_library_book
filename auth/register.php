<?php
    session_start();
    require_once '../api/bd.php';

    if (isset($_SESSION['user'])) {
        header('Location: ../pages/profile.php');
        exit;
    }
    
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name     = trim($_POST['name']);
        $email    = trim($_POST['email']);
        $password = $_POST['password'];

        // Проверка на пустоту
        if (empty($name) || empty($email) || empty($password)) {
            $errors[] = "Заполните все поля.";
        }

        // Проверка на уже существующий email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Пользователь с таким email уже зарегистрирован.";
        }

        if (empty($errors)) {
            $card_name = $name;

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hash]);
            $user_id = $pdo->lastInsertId();
            // Генерируем 6-значный card_number
            do {
                $card_number = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
                $check       = $pdo->prepare("SELECT id FROM library WHERE card_number = ?");
                $check->execute([$card_number]);
            } while ($check->fetch()); // избегаем дубликатов

            // Вставляем карточку
            $card_stmt = $pdo->prepare("INSERT INTO library (card_number, name, user_id) VALUES (?, ?, ?)");
            $card_stmt->execute([$card_number, $card_name, $user_id]);

            // Вход сразу после регистрации
            $user_id          = $pdo->lastInsertId();
            $_SESSION['user'] = [
                'id'          => $user_id,
                'name'        => $name,
                'email'       => $email,
                'card_number' => $card_number,
            ];

            header("Location: ../pages/profile.php");
            exit;
        }
    }
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="register-form-container">
            <div class="main-form">
                <h2 class="mb-4">Register</h2>
                <?php if (! empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php echo implode('<br>', $errors) ?>
                </div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>E-mail</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-success">Register</button>
                    <div class="flex-line">
                        <p>Already have an account?</p><a href="login.php" class="btn btn-link">Login</a>
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