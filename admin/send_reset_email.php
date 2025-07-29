<?php
// send_reset_email.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Настройки SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.yandex.ru';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'motospark1@yandex.ru'; // ← Логин Яндекса
    $mail->Password   = 'enswnnmbkybrfvbm';    // ← Приложение-пароль
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    // Отправитель
    $mail->setFrom('motospark1@yandex.ru', 'Motospark Admin');

    // Получатель
    $email = $_POST['email'];
    $mail->addAddress($email);

    // Генерация токена
    $token = bin2hex(random_bytes(50)); // ← 100-символьный токен
    $resetLink = "http://localhost/Motospark_giga/admin/reset_password.php?token=$token";

    // Вывод информации для диагностики
    echo "📧 Email: $email<br>";
    echo "🔑 Токен: $token<br>";
    echo "🔗 Ссылка: $resetLink<br>";

    // Письмо
    $mail->isHTML(true);
    $mail->Subject = 'Восстановление пароля';
    $mail->Body    = "Нажмите <a href='$resetLink'>здесь</a>, чтобы сбросить пароль.";

    // Сохранение токена в БД
    require '../db.php'; // Подключение к БД
    $stmt = $pdo->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
    $stmt->execute([$token, $email]);

    // Проверка, обновлена ли запись
    if ($stmt->rowCount() === 0) {
        die("❌ Пользователь с email $email не найден.");
    }

    $mail->send();
    echo "✅ Ссылка на восстановление отправлена!";
} catch (Exception $e) {
    echo "❌ Ошибка: {$mail->ErrorInfo}";
}
