<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = floatval($_POST['price']);
    $image = htmlspecialchars($_POST['image']);
    $featured = isset($_POST['featured']) ? 1 : 0;

    $sql = "INSERT INTO products (name, description, price, image, featured) VALUES ('$name', '$description', $price, '$image', $featured)";
    if ($conn->query($sql) === TRUE) {
        echo '<p>Мотоцикл добавлен!</p>';
    } else {
        echo '<p>Ошибка: ' . $conn->error . '</p>';
    }
}
?>

<main>
    <h2>Управление мотоциклами</h2>
    <form method="post">
        <label>Название:</label>
        <input type="text" name="name" required>
        <label>Описание:</label>
        <textarea name="description" required></textarea>
        <label>Цена:</label>
        <input type="number" name="price" step="0.01" required>
        <label>Изображение (URL):</label>
        <input type="text" name="image" required>
        <label>Рекомендуемый:</label>
        <input type="checkbox" name="featured">
        <button type="submit" class="btn">Добавить мотоцикл</button>
    </form>

    <h3>Список мотоциклов</h3>
    <?php
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>Название</th><th>Цена</th><th>Рекомендуемый</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>$' . number_format($row['price'], 2) . '</td>';
            echo '<td>' . ($row['featured'] ? 'Да' : 'Нет') . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>Мотоциклы не найдены.</p>';
    }
    $conn->close();
    ?>
</main>