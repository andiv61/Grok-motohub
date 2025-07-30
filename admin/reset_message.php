<?php
session_start();
require 'config.php';

// Проверяем, был ли установлен токен
if (!isset($_SESSION['reset_token'])) {
    header("Location: forgot_password.php");
    exit;
}

// Очищаем токен после показа сообщения
$token = $_SESSION['reset_token'];
unset($_SESSION['reset_token']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Письмо отправлено</title>
    <style>
        .message { margin: 20px; padding: 15px; border: 1px solid #ddd; background: #f9f9f9; }
    </style>
</head>
<body>
    <div class="message">
        <h2>Инструкции отправлены</h2>
        <p>На указанный email отправлено письмо с инструкциями по сбросу пароля.</p>
        <p>Если письмо не пришло, проверьте папку "Спам" или попробуйте ещё раз.</p>
        <p><a href="login.php">Вернуться к авторизации</a></p>
    </div>
</body>
</html>