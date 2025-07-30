<?php
require 'config.php';

try {
    $pdo = new PDO($dsn, $user, $password, $options);
    
    // Добавляем недостающие столбцы
    $pdo->exec("ALTER TABLE users 
               ADD COLUMN reset_token VARCHAR(100) DEFAULT NULL,
               ADD COLUMN reset_token_expiry DATETIME DEFAULT NULL");
    
    echo "Таблица users успешно обновлена. Столбцы для восстановления пароля добавлены.";
} catch (PDOException $e) {
    die("Ошибка обновления БД: " . $e->getMessage());
}