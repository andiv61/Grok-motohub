<?php
require 'config.php';

try {
    $pdo = new PDO($dsn, $user, $password, $options);
    
    // Проверяем существование таблицы
    if (!tableExists($pdo, 'users')) {
        die("Таблица 'users' не существует. Запустите init_db.php для инициализации БД");
    }
    
    // Хеширование пароля
    $passwordHash = password_hash('testpassword', PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->execute(['testuser', $passwordHash, 'motospark1@yandex.ru']);
    
    echo "Тестовый пользователь успешно добавлен\n";
    
} catch (PDOException $e) {
    die("Ошибка при добавлении пользователя: " . $e->getMessage());
}