<?php
session_start();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_GET['email'];
    $token = $_GET['token'];
    $new_password = trim($_POST['new_password']);
    $stmt = $db->prepare('SELECT * FROM users WHERE email = ? AND reset_token = ? AND reset_expiry > ?');
    $stmt->execute([$email, $token, date('Y-m-d H:i:s')]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $new_hash = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $db->prepare('UPDATE users SET password = ?, reset_token = NULL, reset_expiry = NULL WHERE email = ?');
        $stmt->execute([$new_hash, $email]);
        $message = 'Пароль успешно изменён. Войдите с новым паролем.';
    } else {
        $error = 'Недействительная или истёкшая ссылка';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сброс пароля</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Сброс пароля</h2>
        <?php if (isset($message)): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
            <a href="login.php" class="btn btn-primary">Вернуться к входу</a>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php else: ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="new_password" class="form-label">Новый пароль</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <button type="submit" class="btn btn-primary">Изменить пароль</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>