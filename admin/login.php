<?php
session_start();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        error_log("Вход успешен для $email");
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Неверный email или пароль';
        error_log("Ошибка входа для $email");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    $email = trim($_POST['reset_email']);
    $stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $token = bin2hex(random_bytes(16));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $stmt = $db->prepare('UPDATE users SET reset_token = ?, reset_expiry = ? WHERE email = ?');
        $stmt->execute([$token, $expiry, $email]);
        $reset_link = "http://localhost/Grok-motohub/admin/reset_password.php?email=$email&token=$token";
        mail($email, 'Сброс пароля Racer', "Перейдите по ссылке для сброса пароля: $reset_link", 'From: no-reply@racer.ru');
        $reset_message = 'Ссылка для сброса пароля отправлена на ваш email';
    } else {
        $reset_error = 'Email не найден';
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Вход в админ-панель</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="login" value="1">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="admin@racer.ru" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Войти</button>
            <a href="#" data-bs-toggle="modal" data-bs-target="#resetModal">Забыли пароль?</a>
        </form>

        <!-- Modal для восстановления пароля -->
        <div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resetModalLabel">Восстановление пароля</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php if (isset($reset_message)): ?>
                            <div class="alert alert-success"><?php echo $reset_message; ?></div>
                        <?php endif; ?>
                        <?php if (isset($reset_error)): ?>
                            <div class="alert alert-danger"><?php echo $reset_error; ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <input type="hidden" name="reset" value="1">
                            <div class="mb-3">
                                <label for="reset_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="reset_email" name="reset_email" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Отправить ссылку</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>