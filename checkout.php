<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_name = htmlspecialchars($_POST['customer_name']);
    $customer_email = htmlspecialchars($_POST['customer_email']);
    $total = 0;

    foreach ($_SESSION['cart'] as $id => $quantity) {
        $sql = "SELECT price FROM products WHERE id = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total += $row['price'] * $quantity;
        }
    }

    $sql = "INSERT INTO orders (customer_name, customer_email, total) VALUES ('$customer_name', '$customer_email', $total)";
    if ($conn->query($sql) === TRUE) {
        unset($_SESSION['cart']);
        echo '<p>Заказ успешно оформлен!</p>';
    } else {
        echo '<p>Ошибка при оформлении заказа.</p>';
    }
    $conn->close();
} else {
?>
<main>
    <h2>Оформление заказа</h2>
    <form method="post">
        <label>Имя:</label>
        <input type="text" name="customer_name" required>
        <label>Email:</label>
        <input type="email" name="customer_email" required>
        <button type="submit" class="btn">Подтвердить заказ</button>
    </form>
</main>
<?php
}
include 'includes/footer.php';
?>