<?php
// admin/process_reset.php

require '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_POST['token'];
    $password = $_POST['password'];

    // Проверка токена
    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        die("❌ Недействительный токен.");
    }

    // Хешируем новый пароль
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Обновляем пароль, удаляем токен
    $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?");
    $stmt->execute([$hashedPassword, $token]);

    echo "✅ Пароль успешно сброшен. Теперь вы можете войти.";
}