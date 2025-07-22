<?php
require '../includes/header.php';
require '../includes/db.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $type = $_POST['type'];
    $stmt = $db->prepare('INSERT INTO customers (name, email, phone, type) VALUES (?, ?, ?, ?)');
    $stmt->execute([$name, $email, $phone, $type]);
    header('Location: customers.php');
    exit;
}
?>
<h2>Клиенты</h2>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" href="#retail" data-bs-toggle="tab">Розничные</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#wholesale" data-bs-toggle="tab">Оптовые</a>
    </li>
</ul>
<div class="tab-content mt-3">
    <div class="tab-pane fade show active" id="retail">
        <h3>Розничные клиенты</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Телефон</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $db->query("SELECT * FROM customers WHERE type = 'retail'");
                while ($customer = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr><td>{$customer['name']}</td><td>{$customer['email']}</td><td>{$customer['phone']}</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="tab-pane fade" id="wholesale">
        <h3>Оптовые клиенты</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Телефон</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $db->query("SELECT * FROM customers WHERE type = 'wholesale'");
                while ($customer = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr><td>{$customer['name']}</td><td>{$customer['email']}</td><td>{$customer['phone']}</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<h3>Добавить клиента</h3>
<form method="POST">
    <input type="text" class="form-control mb-2" name="name" placeholder="Имя" required>
    <input type="email" class="form-control mb-2" name="email" placeholder="Email" required>
    <input type="text" class="form-control mb-2" name="phone" placeholder="Телефон" required>
    <select name="type" class="form-control mb-2">
        <option value="retail">Розничный</option>
        <option value="wholesale">Оптовый</option>
    </select>
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>
<?php require '../includes/footer.php'; ?>