<!-- login.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход в админку</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; }
        .container { width: 300px; margin: 100px auto; background: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input[type="email"], input[type="password"] { width: 100%; padding: 10px; margin: 10px 0; }
        button { width: 100%; padding: 10px; background: #4CAF50; color: white; border: none; }
        a { display: block; text-align: right; margin-top: 10px; color: #4CAF50; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Вход в админку</h2>
        <form method="POST" action="login_process.php">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Пароль" required><br>
            <button type="submit">Войти</button>
            <a href="#" onclick="document.getElementById('forgot-form').style.display='block'; return false;">Забыли пароль?</a>
        </form>

        <!-- Форма для восстановления пароля -->
        <div id="forgot-form" style="display:none; margin-top: 10px;">
            <h3>Восстановление пароля</h3>
            <form method="POST" action="send_reset_email.php">
                <input type="email" name="email" placeholder="Ваш email" required><br>
                <button type="submit">Отправить ссылку</button>
            </form>
        </div>
    </div>
</body>
</html>
