<?php
session_start();
require 'config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Восстановление пароля</title>
    <style>
        .container { max-width: 500px; margin: 50px auto; }
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid; }
        .alert-error { color: #a94442; background-color: #f2dede; }
        .form-group { margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Восстановление пароля</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="send_reset_email.php" method="POST">
            <div class="form-group">
                <label>Введите ваш email:</label>
                <input type="email" name="email" required class="form-control">
            </div>
            <button type="submit" class="btn">Отправить ссылку</button>
        </form>
    </div>
</body>
</html>