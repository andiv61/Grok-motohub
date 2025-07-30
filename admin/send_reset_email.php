<?php
session_start();
require 'config.php';

// Подключение PHPMailer без Composer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    
    try {
        $pdo = new PDO($dsn, $user, $password, $options);
        
        // Проверка пользователя
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            $token = bin2hex(random_bytes(32));
            $expiry = date("Y-m-d H:i:s", time() + 3600); // 1 час
            
            // Обновление токена в БД
            $update = $pdo->prepare("UPDATE users SET 
                                   reset_token = ?, 
                                   reset_token_expiry = ? 
                                   WHERE id = ?");
            $update->execute([$token, $expiry, $user['id']]);
            
            // Настройка и отправка письма
            $mail = new PHPMailer(true);
            
            // Конфигурация SMTP Яндекс
            $mail->isSMTP();
            $mail->Host = 'smtp.yandex.ru';
            $mail->SMTPAuth = true;
            $mail->Username = 'motospark1@yandex.ru';
            $mail->Password = 'enswnnmbkybrfvbm'; // Замените на реальный пароль
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->CharSet = 'UTF-8';
            
            // Формирование письма
            $resetLink = "http://localhost/Motospark_giga/admin/password_reset_form.php?token=$token";
            
            $mail->setFrom('motospark1@yandex.ru', 'Motospark');
            $mail->addAddress($email);
            $mail->Subject = 'Восстановление пароля Motospark';
            
            // HTML-версия письма
            $mail->isHTML(true);
            $mail->Body = "
                <h2>Восстановление пароля</h2>
                <p>Для сброса пароля перейдите по ссылке:</p>
                <p><a href=\"$resetLink\">$resetLink</a></p>
                <p>Ссылка действительна 1 час.</p>
            ";
            
            // Текстовая версия для почтовых клиентов
            $mail->AltBody = "Для сброса пароля перейдите по ссылке:\n$resetLink\n\nСсылка действительна 1 час.";
            
            // Отправка письма
            $mail->send();
            
            $_SESSION['message'] = "На $email отправлена ссылка для сброса пароля";
            header("Location: password_reset_message.php");
            exit;
        } else {
            $_SESSION['error'] = "Пользователь с таким email не найден";
            header("Location: password_reset_request.php");
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Ошибка сервера: попробуйте позже";
        error_log("Mail Error: " . $e->getMessage());
        header("Location: password_reset_request.php");
        exit;
    }
}

header("Location: password_reset_request.php");
exit;