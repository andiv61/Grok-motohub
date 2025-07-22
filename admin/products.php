<?php
require '../includes/header.php';
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'add') {
    $stmt = $db->prepare('INSERT INTO products (name, article, dealer_price, retail_price, stock, category, description) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$_POST['name'], $_POST['article'], $_POST['dealer_price'], $_POST['retail_price'], $_POST['stock'], $_POST['category'], $_POST['description']]);
    header('Location: products.php');
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'list') {
    $stmt = $db->query('SELECT * FROM products');
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'get' && isset($_GET['id'])) {
    $stmt = $db->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $stmt = $db->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$_POST['id']]);
    echo json_encode(['message' => 'Product deleted']);
    exit;
}
?>
<h2>Товары</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Название</th>
            <th>Артикул</th>
            <th>Цена (розница)</th>
            <th>Остаток</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody id="products-table"></tbody>
</table>
<h3>Добавить товар</h3>
<form method="POST" action="products.php?action=add">
    <input type="text" class="form-control mb-2" name="name" placeholder="Название" required>
    <input type="text" class="form-control mb-2" name="article" placeholder="Артикул" required>
    <input type="number" class="form-control mb-2" name="dealer_price" placeholder="Дилерская цена" required>
    <input type="number" class="form-control mb-2" name="retail_price" placeholder="Розничная цена" required>
    <input type="number" class="form-control mb-2" name="stock" placeholder="Остаток" required>
    <input type="text" class="form-control mb-2" name="category" placeholder="Категория">
    <textarea class="form-control mb-2" name="description" placeholder="Описание"></textarea>
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>
<?php require '../includes/footer.php'; ?>