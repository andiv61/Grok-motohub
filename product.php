<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<main>
    <?php
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $sql = "SELECT * FROM products WHERE id = $id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '<div class="product-details">';
            echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
            echo '<h2>' . htmlspecialchars($row['name']) . '</h2>';
            echo '<p>' . htmlspecialchars($row['description']) . '</p>';
            echo '<p>Цена: $' . number_format($row['price'], 2) . '</p>';
            echo '<form action="cart.php" method="post">';
            echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
            echo '<input type="number" name="quantity" value="1" min="1">';
            echo '<button type="submit" class="btn">Добавить в корзину</button>';
            echo '</form>';
            echo '</div>';
        } else {
            echo '<p>Мотоцикл не найден.</p>';
        }
    } else {
        echo '<p>Идентификатор товара не указан.</p>';
    }
    $conn->close();
    ?>
</main>

<?php include 'includes/footer.php'; ?>