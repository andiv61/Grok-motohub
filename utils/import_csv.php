<?php
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (($handle = fopen('../products.csv', 'r')) !== false) {
        $header = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== false) {
            $stmt = $db->prepare('INSERT OR IGNORE INTO products (name, article, dealer_price, retail_price, stock, category, description) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute($data);
        }
        fclose($handle);
    }
    header('Location: ../admin/products.php');
}
?>
<form method="POST">
    <button type="submit" class="btn btn-secondary">Импорт CSV</button>
</form>