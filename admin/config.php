<?php
$host = 'localhost';
$dbname = 'motospark'; // Имя базы, которую вы только что создали
$user = 'root';      // Стандартный пользователь XAMPP
$password = '';      // Пустой пароль по умолчанию в XAMPP
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Функция для проверки таблиц
function tableExists($pdo, $tableName) {
    try {
        $result = $pdo->query("SELECT 1 FROM $tableName LIMIT 1");
        return true;
    } catch (PDOException $e) {
        return false;
    }
}