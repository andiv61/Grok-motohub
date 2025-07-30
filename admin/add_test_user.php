<?php
require_once __DIR__ . '/../db.php';

$email = 'motospark1@yandex.ru';
$password = password_hash('moto12345', PASSWORD_DEFAULT);
$role = 'user';

// Проверяем, существует ли пользователь
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch();

if ($user) {
    echo "✅ Пользователь уже существует.<br>";
} else {
    $stmt = $pdo->prepare("INSERT INTO users (email, password, role) VALUES (:email, :password, :role)");
    $stmt->execute([
        'email' => $email,
        'password' => $password,
        'role' => $role
    ]);
    echo "✅ Пользователь успешно добавлен.<br>";
}
?>