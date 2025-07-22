<?php
require '../includes/header.php';
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'ozon') {
    $stmt = $db->query('SELECT * FROM products');
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $ozon_products = array_map(function($p) {
        return [
            'name' => $p['name'],
            'offer_id' => $p['article'],
            'price' => $p['retail_price'],
            'quantity' => $p['stock']
        ];
    }, $products);
    $response = file_get_contents('https://api-seller.ozon.ru/v2/product/import', false, stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\nApi-Key: YOUR_OZON_API_KEY",
            'content' => json_encode(['items' => $ozon_products])
        ]
    ]));
    echo $response;
    exit;
}
?>
<h2>Маркетплейсы</h2>
<form method="POST" action="marketplaces.php?action=ozon">
    <button type="submit" class="btn btn-primary">Выгрузить товары на Ozon</button>
</form>
<?php require '../includes/footer.php'; ?>