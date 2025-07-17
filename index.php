<?php include 'includes/header.php'; ?>

<main>
    <section class="hero">
        <h1>Добро пожаловать в Racer Motorcycles</h1>
        <p>Лучшие гоночные мотоциклы для скорости и стиля.</p>
        <a href="motorcycles.php" class="btn">Перейти в каталог</a>
    </section>
    <section class="featured">
        <h2>Рекомендуемые мотоциклы</h2>
        <div class="product-grid">
            <?php
            include 'includes/db.php';
            $sql = "SELECT * FROM products WHERE featured = 1 LIMIT 3";
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
                echo '<p>Нет рекомендуемых мотоциклов.</p>';
            }
            $conn->close();
            ?>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>