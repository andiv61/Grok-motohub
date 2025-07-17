<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
?>

<main>
    <h2>Админ-панель</h2>
    <p>Добро пожаловать, администратор!</p>
    <ul>
        <li><a href="products.php">Управление мотоциклами</a></li>
        <li><a href="orders.php">Управление заказами</a></li>
        <li><a href="logout.php">Выйти</a></li>
    </ul>
</main>