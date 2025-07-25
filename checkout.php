<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = htmlspecialchars($_POST['customer_name']);
    $customer_phone = htmlspecialchars($_POST['customer_phone']);
    $total = 0;

    foreach ($_SESSION['cart'] as $id => $quantity) {
        $stmt = $db->prepare("SELECT retail_price FROM products WHERE id = ?");
        $stmt->execute([$id]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $total += $row['retail_price'] * $quantity;
        }
    }

    // Пример: один заказ = одна позиция, если нужна детализация, делайте таблицу order_items
    $stmt = $db->prepare("INSERT INTO orders (customer_name, customer_phone, status, source) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$customer_name, $customer_phone, 'новый', 'site'])) {
        unset($_SESSION['cart']);
        echo '<p>Заказ успешно оформлен!</p>';
    } else {
        echo '<p>Ошибка при оформлении заказа.</p>';
    }
} else {
?>
<main>
<!-- форма заказа -->
<?php } ?>