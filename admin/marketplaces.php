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

    $api_key = 'ВАШ_OZON_API_KEY';
    $ch = curl_init('https://api-seller.ozon.ru/v2/product/import');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Api-Key: $api_key"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['items' => $ozon_products]));
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    exit;
}
?>
<!-- остальной HTML -->