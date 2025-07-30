<?php
// admin/send_reset_email.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require '../db.php'; // Подключение к SQLite

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);

    // Проверка, существует ли пользователь с таким email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        die("❌ Email не найден.");
    }

    // Генерация токена
    $token = bin2hex(random_bytes(50));

    // Сохраняем токен
    $stmt = $pdo->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
    $stmt->execute([$token, $email]);

    // Ссылка для сброса пароля
    $resetLink = "http://localhost/Motospark_giga/admin/reset_password.php?token=$token";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.yandex.ru';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'motospark1@yandex.ru';
        $mail->Password   = 'enswnnmbkybrfvbm'; // App-пароль из Яндекса
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('motospark1@yandex.ru', 'Motospark Admin');
        $mail->addAddress($email);

        $mail->Subject = 'Сброс пароля';
        $mail->Body    = "Чтобы сбросить пароль, перейдите по ссылке:\n$resetLink";

        $mail->send();

        echo "✅ Письмо отправлено. Проверьте вашу почту.";
    } catch (Exception $e) {
        echo "❌ Ошибка отправки: {$mail->ErrorInfo}";
    }
}