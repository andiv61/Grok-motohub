<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include '../includes/db.php';
?>

<main>
    <h2>Управление заказами</h2>
    <?php
    $sql = "SELECT * FROM orders";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>Клиент</th><th>Email</th><th>Сумма</th><th>Дата</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['customer_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['customer_email']) . '</td>';
            echo '<td>$' . number_format($row['total'], 2) . '</td>';
            echo '<td>' . $row['created_at'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>Заказы не найдены.</p>';
    }
    $conn->close();
    ?>
</main>