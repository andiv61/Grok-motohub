<?php
require '../includes/header.php';
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'add') {
    $stmt = $db->prepare('INSERT INTO orders (product_id, quantity, customer_id, status, source) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$_POST['product_id'], $_POST['quantity'], $_POST['customer_id'], 'новый', $_POST['source']]);
    $order_id = $db->lastInsertId();
    $stmt = $db->prepare('UPDATE products SET stock = stock - ? WHERE id = ?');
    $stmt->execute([$_POST['quantity'], $_POST['product_id']]);
    $stmt = $db->prepare('SELECT name FROM customers WHERE id = ?');
    $stmt->execute([$_POST['customer_id']]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    // Telegram notification
    $bot_token = 'YOUR_BOT_TOKEN';
    $chat_id = 'YOUR_CHAT_ID';
    file_get_contents("https://api.telegram.org/bot$bot_token/sendMessage?chat_id=$chat_id&text=Новый заказ #$order_id: {$customer['name']}, {$_POST['quantity']} шт.");
    header('Location: orders.php');
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'list') {
    $stmt = $db->query('SELECT o.*, c.name as customer_name FROM orders o JOIN customers c ON o.customer_id = c.id');
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}
?>
<h2>Заказы</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Клиент</th>
            <th>Товар</th>
            <th>Количество</th>
            <th>Статус</th>
        </tr>
    </thead>
    <tbody id="orders-table"></tbody>
</table>
<h3>Добавить заказ</h3>
<form method="POST" action="orders.php?action=add">
    <select name="product_id" class="form-control mb-2" required>
        <?php
        $stmt = $db->query('SELECT id, name FROM products');
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$product['id']}'>{$product['name']}</option>";
        }
        ?>
    </select>
    <input type="number" class="form-control mb-2" name="quantity" placeholder="Количество" required>
    <select name="customer_id" class="form-control mb-2" required>
        <?php
        $stmt = $db->query('SELECT id, name FROM customers');
        while ($customer = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='{$customer['id']}'>{$customer['name']}</option>";
        }
        ?>
    </select>
    <input type="text" class="form-control mb-2" name="source" placeholder="Источник (сайт/Ozon)" required>
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>
<?php require '../includes/footer.php'; ?>