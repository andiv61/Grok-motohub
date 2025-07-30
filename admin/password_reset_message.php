<?php
session_start();
require 'config.php';

if (empty($_SESSION['message'])) {
    header("Location: password_reset_request.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Письмо отправлено</title>
    <style>
        .message-box { 
            max-width: 600px; 
            margin: 50px auto; 
            padding: 20px;
            border: 1px solid #ddd;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="message-box">
        <h2>✔ Письмо отправлено</h2>
        <p><?= $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <p><a href="login.php">Вернуться к авторизации</a></p>
    </div>
</body>
</html>