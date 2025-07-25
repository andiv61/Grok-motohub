<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Если используете Composer:
require_once _DIR_ . '/../vendor/autoload.php';
// Если скачивали PHPMailer вручную, раскомментируйте две строки ниже и поправьте путь
// require_once _DIR_ . '/PHPMailer/src/Exception.php';
// require_once _DIR_ . '/PHPMailer/src/PHPMailer.php';
// require_once _DIR_ . '/PHPMailer/src/SMTP.php';

function sendMail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.yandex.ru';
        $mail->SMTPAuth = true;
        $mail->Username = 'ВАШ_ЯЩИК@yandex.ru'; // например, noreply.yourproject@yandex.ru
        $mail->Password = 'ПАРОЛЬ_ПРИЛОЖЕНИЯ'; // пароль приложения из шага 2
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('ВАШ_ЯЩИК@yandex.ru', 'MotoHub');
        $mail->addAddress($to);

        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(false); // если хотите html-письма, поставьте true

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>