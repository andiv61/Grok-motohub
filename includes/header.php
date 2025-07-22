<?php
session_start();
if (!isset($_SESSION['user_id']) && !str_contains($_SERVER['REQUEST_URI'], 'login.php') && !str_contains($_SERVER['REQUEST_URI'], 'reset_password.php')) {
    header('Location: login.php');
    exit;
}
$role = $_SESSION['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Racer Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Racer Admin</a>
            <div class="navbar-nav">
                <a class="nav-link" href="dashboard.php">Дашборд</a>
                <?php if ($role === 'admin' || $role === 'manager'): ?>
                    <a class="nav-link" href="products.php">Товары</a>
                    <a class="nav-link" href="orders.php">Заказы</a>
                <?php endif; ?>
                <?php if ($role === 'admin' || $role === 'warehouse'): ?>
                    <a class="nav-link" href="stock.php">Склад</a>
                <?php endif; ?>
                <?php if ($role === 'admin'): ?>
                    <a class="nav-link" href="analytics.php">Аналитика</a>
                    <a class="nav-link" href="marketplaces.php">Маркетплейсы</a>
                    <a class="nav-link" href="employees.php">Сотрудники</a>
                    <a class="nav-link" href="customers.php">Клиенты</a>
                <?php endif; ?>
                <a class="nav-link" href="telegram.php">Telegram</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a class="nav-link" href="logout.php">Выход</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container mt-4">