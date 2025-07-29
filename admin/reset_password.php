<?php
// reset_password.php
require '../db.php'; // Подключение к БД

if (!isset($_GET['token'])) {
    die("❌ Неверный запрос.");
}

$token = $_GET['token'];

// Добавим отладку: выведем токен и запрос
echo "Полученный токен: $token<br>";
$stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    die("❌ Токен недействителен.");
}
?>

<h2>Сброс пароля</h2>
<form method="POST" action="process_reset.php">
    <input type="hidden" name="token" value="<?= $token ?>">
    <input type="password" name="password" placeholder="Новый пароль" required><br>
    <button type="submit">Сохранить</button>
</form>
