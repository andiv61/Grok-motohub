<?php
require 'config.php';

try {
    $pdo = new PDO($dsn, $user, $password, $options);
    
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100),
        reset_token VARCHAR(100),
        reset_token_expiry DATETIME,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $pdo->exec($sql);
    
    // Добавляем тестового пользователя
    $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT IGNORE INTO users (username, password, email) 
               VALUES ('admin', '$hashedPassword', 'admin@example.com')");
    
    echo "Таблица users создана. Тестовый пользователь: admin/admin123";
} catch (PDOException $e) {
    die("Ошибка инициализации БД: " . $e->getMessage());
}