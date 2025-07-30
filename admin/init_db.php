<?php
require_once 'config.php';

try {
    // Подключаемся без указания базы данных
    $pdo = new PDO("mysql:host=$host;charset=$charset", $user, $password, $options);
    
    // Создаем базу данных если не существует
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    $pdo->exec("USE `$dbname`");
    
    // Правильный SQL для MariaDB/MySQL
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100),
        role VARCHAR(20) DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $pdo->exec($sql);
    
    echo "База данных и таблица 'users' успешно созданы!<br>";
    echo "Можете перейти к <a href='add_test_user.php'>добавлению тестового пользователя</a>";
    
} catch (PDOException $e) {
    die("Ошибка инициализации БД: " . $e->getMessage());
}