<?php
require '../includes/header.php';
require '../includes/db.php';

$stmt = $db->query('SELECT * FROM products WHERE stock < 10');
$low_stock = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($low_stock) {
    $bot_token = 'YOUR_BOT_TOKEN';
    $chat_id = 'YOUR_CHAT_ID';
    foreach ($low_stock as $product) {
        file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=Низкий остаток: {$product['name']} ({$product['stock']} шт.)");
    }
}
?>
<h2>Склад</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Название</th>
            <th>Артикул</th>
            <th>Остаток</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $db->query('SELECT * FROM products');
        foreach ($stmt as $product) {
            echo "<tr><td>{$product['name']}</td><td>{$product['article']}</td><td>{$product['stock']}</td></tr>";
        }
        ?>
    </tbody>
</table>
<?php require '../includes/footer.php'; ?>