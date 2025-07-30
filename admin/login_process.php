<?php
session_start();
require 'config.php';

// Добавляем проверку существования таблицы
try {
    $pdo = new PDO($dsn, $user, $password, $options);
    
    // Проверка существования таблицы
    $tableExists = $pdo->query("SELECT 1 FROM information_schema.tables 
                              WHERE table_schema = '$dbname' 
                              AND table_name = 'users'")->fetchColumn();
    
    if (!$tableExists) {
        die("Ошибка: Таблица пользователей не существует. Обратитесь к администратору.");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: dashboard.php");
                exit;
            } else {
                $_SESSION['error'] = "Неверный пароль";
            }
        } else {
            $_SESSION['error'] = "Пользователь не найден";
        }
    }
} catch (PDOException $e) {
    error_log("Login Error: " . $e->getMessage());
    $_SESSION['error'] = "Ошибка системы. Попробуйте позже.";
}

header("Location: login.php");
exit;