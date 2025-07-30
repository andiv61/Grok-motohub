<?php
// admin/reset_password.php

require '../db.php';

if (!isset($_GET['token'])) {
    die("❌ Токен отсутствует.");
}

$token = $_GET['token'];

// Проверка токена
$stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    die("❌ Токен недействителен или просрочен.");
}
?>

<h2>Сброс пароля</h2>
<form method="POST" action="process_reset.php">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    <input type="password" name="password" placeholder="Новый пароль" required><br>
    <button type="submit">Сбросить пароль</button>
</form>