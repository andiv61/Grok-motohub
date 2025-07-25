<?php
require '../includes/header.php';
require '../includes/db.php';

// Вынести токен и chat_id в конфиг!
$bot_token = 'ВАШ_ТОКЕН';
$chat_id = 'ВАШ_CHAT_ID';

$stmt = $db->query('SELECT * FROM products WHERE stock < 10');
$low_stock = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($low_stock) {
    foreach ($low_stock as $product) {
        file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=Низкий остаток: {$product['name']} ({$product['stock']} шт.)");
    }
}
?>
<!-- остальной HTML -->