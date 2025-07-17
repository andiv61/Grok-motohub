<?php
session_start();
include 'includes/header.php';
include 'includes/db.php';
?>

<main>
    <h2>Корзина</h2>
    <?php
    if (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        $_SESSION['cart'][$product_id] = isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id] + $quantity : $quantity;
    }

    if (!empty($_SESSION['cart'])) {
        $total = 0;
        echo '<table>';
        echo '<tr><th>Мотоцикл</th><th>Цена</th><th>Количество</th><th>Итого</th></tr>';
        foreach ($_SESSION['cart'] as $id => $quantity) {
            $sql = "SELECT * FROM products WHERE id = $id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $subtotal = $row['price'] * $quantity;
                $total += $subtotal;
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>$' . number_format($row['price'], 2) . '</td>';
                echo '<td>' . $quantity . '</td>';
                echo '<td>$' . number_format($subtotal, 2) . '</td>';
                echo '</tr>';
            }
        }
        echo '<tr><td colspan="3">Общая сумма:</td><td>$' . number_format($total, 2) . '</td></tr>';
        echo '</table>';
        echo '<a href="checkout.php" class="btn">Оформить заказ</a>';
    } else {
        echo '<p>Корзина пуста.</p>';
    }
    $conn->close();
    ?>
</main>

<?php include 'includes/footer.php'; ?>