<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

echo "🔧 Начинаем тестирование...<br>";

$mail = new PHPMailer(true);

try {
    // Конфигурация SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.yandex.ru';
    $mail->SMTPAuth = true;
    $mail->Username = 'motospark1@yandex.ru'; // Ваш полный email
    $mail->Password = 'enswnnmbkybrfvbm'; // Пароль приложения, не основной!
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Используем SSL
    $mail->Port = 465; // Порт для SSL
    
    echo "📧 Конфигурация:<br>";
    echo "- Хост: smtp.yandex.ru<br>";
    echo "- Порт: 465<br>";
    echo "- Шифрование: ssl<br>";
    echo "- Логин: motospark1@yandex.ru<br>";

    // Отправитель и получатель (должны совпадать с логином)
    $mail->setFrom('motospark1@yandex.ru', 'MotoSpark');
    $mail->addAddress('motospark1@yandex.ru', 'Получатель');
    
    echo "📤 Отправитель: motospark1@yandex.ru<br>";
    echo "📬 Получатель: motospark1@yandex.ru<br>";

    // Содержание письма
    $mail->isHTML(true);
    $mail->Subject = 'Тестовое письмо';
    $mail->Body = 'Это тестовое письмо отправлено через PHPMailer';
    
    echo "📩 Отправка письма...<br>";
    
    // Включение подробного вывода (для отладки)
    $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
    
    $mail->send();
    
} catch (Exception $e) {
}
