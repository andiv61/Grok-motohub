<?php
session_start();
require 'config.php';

$token = $_GET['token'] ?? '';

if (empty($token)) {
    $_SESSION['error'] = "Неверная ссылка для сброса пароля";
    header("Location: password_reset_request.php");
    exit;
}

try {
    $pdo = new PDO($dsn, $user, $password, $options);
    
    // Проверяем токен
    $stmt = $pdo->prepare("SELECT id, reset_token_expiry FROM users WHERE reset_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();
    
    // Отладочная информация
    error_log("Token check: " . print_r($user, true));
    
    if (!$user) {
        $_SESSION['error'] = "Неверная ссылка для сброса";
        header("Location: password_reset_request.php");
        exit;
    }
    
    if (strtotime($user['reset_token_expiry']) < time()) {
        $_SESSION['error'] = "Срок действия ссылки истек";
        header("Location: password_reset_request.php");
        exit;
    }

    // Обработка формы
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newPassword = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'];
        
        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = "Пароли не совпадают";
        } else {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $update = $pdo->prepare("UPDATE users SET 
                                   password = ?,
                                   reset_token = NULL,
                                   reset_token_expiry = NULL 
                                   WHERE id = ?");
            $update->execute([$hashedPassword, $user['id']]);
            
            $_SESSION['message'] = "Пароль успешно изменен!";
            header("Location: login.php");
            exit;
        }
    }
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    $_SESSION['error'] = "Ошибка сервера";
    header("Location: password_reset_request.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новый пароль</title>
    <style>
        .container { max-width: 500px; margin: 50px auto; padding: 20px; border: 1px solid #ddd; }
        .alert { padding: 10px; margin-bottom: 15px; }
        .error { background: #ffebee; color: #c62828; }
        .form-group { margin-bottom: 15px; }
        input[type="password"] { width: 100%; padding: 8px; }
        button { padding: 10px 15px; background: #2196F3; color: white; border: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Установите новый пароль</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Новый пароль:</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Повторите пароль:</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit">Сохранить</button>
        </form>
    </div>
</body>
</html>