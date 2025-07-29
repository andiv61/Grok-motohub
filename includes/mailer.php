<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Исправлено! Было DIR → _DIR_
require_once _DIR_ . '/../vendor/autoload.php';

function sendMail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.yandex.ru';
        $mail->SMTPAuth = true;
        $mail->Username = 'motospark1@yandex.ru';
        $mail->Password = 'enswnnmbkybrfvbm'; // пароль приложения Яндекс
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('motospark1@yandex.ru', 'MotoSpark');
        $mail->addAddress($to);

        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(false);

        // Временно для диагностики (убрать после теста):
        // $mail->SMTPDebug = 2;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mail error: {$mail->ErrorInfo}");
        return false;
    }
}
?>