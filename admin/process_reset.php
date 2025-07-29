<?php
// process_reset.php
require '../db.php'; // Подключение к БД

if (!isset($_POST['token'], $_POST['password'])) {
    die("❌ Неверный запрос.");
}

$token = $_POST['token'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?");
$stmt->execute([$password, $token]);

echo "✅ Пароль успешно изменён!";
