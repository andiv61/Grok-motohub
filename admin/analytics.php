<?php
require '../includes/db.php';
if (isset($_GET['action']) && $_GET['action'] === 'sales') {
    $stmt = $db->query('SELECT p.category, SUM(o.quantity) as total FROM orders o JOIN products p ON o.product_id = p.id GROUP BY p.category');
    $data = ['Мопеды' => 0, 'Скутеры' => 0, 'Мотоциклы' => 0, 'Шлемы' => 0];
    foreach ($stmt as $row) {
        $data[$row['category']] = $row['total'];
    }
    echo json_encode(array_values($data));
    exit;
}
require '../includes/header.php';
?>
<h2>Аналитика</h2>
<canvas id="salesChart" style="max-height: 300px;"></canvas>
<?php require '../includes/footer.php'; ?>