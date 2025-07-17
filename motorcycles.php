<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>

<main>
    <section class="catalog">
        <h2>Каталог мотоциклов</h2>
        <div class="product-grid">
            <?php
            $sql = "SELECT * FROM products";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product-card">';
                    echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p>$' . number_format($row['price'], 2) . '</p>';
                    echo '<a href="product.php?id=' . $row['id'] . '" class="btn">Подробнее</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>Мотоциклы не найдены.</p>';
            }
            $conn->close();
            ?>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>