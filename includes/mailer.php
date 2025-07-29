<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once _DIR_ . '/../vendor/autoload.php';

function sendMail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.yandex.ru';
        $mail->SMTPAuth = true;
        $mail->Username = 'motospark1@yandex.ru';
        $mail->Password = 'gjibxnrggjfgpwdp'; // пароль приложения Яндекса
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('motospark1@yandex.ru', 'MotoSpark');
        $mail->addAddress($to);

        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML(false);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mail error: {$mail->ErrorInfo}");
        return false;
    }
}
?>