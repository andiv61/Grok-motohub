// После генерации токена $token и перед перенаправлением:

$to = $email;
$subject = "Восстановление пароля Motospark";

// Формируем ссылку с абсолютным путем
$resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/Motospark_giga/admin/reset_password.php?token=" . urlencode($token);

// HTML-версия письма
$message = '
<html>
<head>
    <title>Восстановление пароля</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .button { 
            background: #0066cc; color: white; 
            padding: 10px 15px; text-decoration: none;
            border-radius: 4px; display: inline-block;
        }
    </style>
</head>
<body>
    <h2>Восстановление пароля</h2>
    <p>Для сброса пароля нажмите кнопку ниже:</p>
    <p><a href="'.$resetLink.'" class="button">Сбросить пароль</a></p>
    <p>Или скопируйте ссылку в браузер:<br>'.$resetLink.'</p>
    <p><small>Ссылка действительна 1 час. Если вы не запрашивали сброс пароля, проигнорируйте это письмо.</small></p>
</body>
</html>';

// Текстовая версия для почтовых клиентов без поддержки HTML
$textVersion = "Для сброса пароля перейдите по ссылке:\n\n"
             . $resetLink . "\n\n"
             . "Ссылка действительна 1 час.";

// Формируем заголовки
$headers = "From: Motospark <no-reply@motospark.ru>\r\n";
$headers .= "Reply-To: support@motospark.ru\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Отправляем письмо
$mailSent = mail($to, $subject, $message, $headers);

if (!$mailSent) {
    // Логируем ошибку
    error_log("[" . date('Y-m-d H:i:s') . "] Ошибка отправки письма на $email: " . print_r(error_get_last(), true));
    
    $_SESSION['error'] = "Ошибка отправки письма. Попробуйте позже или обратитесь в поддержку.";
    header("Location: forgot_password.php");
    exit;
}

// Логируем успешную отправку
error_log("[" . date('Y-m-d H:i:s') . "] Письмо для сброса пароля отправлено на $email");