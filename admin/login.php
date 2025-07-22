<?php
session_start();
require '../includes/db.php';

// Включаем отображение ошибок для отладки
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Отладка: выводим полученные данные
    error_log("Получен логин: $username, пароль: $password");
    
    $stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Отладка: проверяем, найден ли пользователь
    if ($user) {
        error_log("Пользователь найден: " . print_r($user, true));
    } else {
        error_log("Пользователь с логином $username не найден");
    }
    
    // Проверяем пароль
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        error_log("Вход успешен для пользователя $username");
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Неверный логин или пароль';
        error_log("Ошибка входа: неверный логин или пароль");
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Вход в админ-панель</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Логин</label>
                <input type="text" class="form-control" id="username" name="username" value="admin" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">Показать</button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>
    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const button = document.querySelector('button[onclick="togglePassword()"]');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                button.textContent = 'Скрыть';
            } else {
                passwordField.type = 'password';
                button.textContent = 'Показать';
            }
        }
    </script>
</body>
</html>