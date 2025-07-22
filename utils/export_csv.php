<?php
require '../includes/db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="products.csv"');
$output = fopen('php://output', 'w');
fputcsv($output, ['name', 'article', 'dealer_price', 'retail_price', 'stock', 'category', 'description']);
$stmt = $db->query('SELECT name, article, dealer_price, retail_price, stock, category, description FROM products');
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, $row);
}
fclose($output);
exit;