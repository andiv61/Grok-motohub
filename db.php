<?php
// db.php
$host = 'localhost';      // Хост базы данных
$db   = 'motospark_db';   // Имя вашей БД (должно совпадать с созданной)
$user = 'root';           // Логин MySQL (по умолчанию для XAMPP)
$pass = '';               // Пароль MySQL (обычно пустой)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
