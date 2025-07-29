<?php
// login_process.php
require '../db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
    session_start();
    $_SESSION['admin'] = true;
    header('Location: ../admin/dashboard.php');
    exit();
} else {
    echo "❌ Неверный email или пароль.";
}
