<?php
require '../includes/header.php';
require '../includes/db.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $stmt = $db->prepare('INSERT INTO users (email, password, role) VALUES (?, ?, ?)');
    $stmt->execute([$email, $password, $role]);
    header('Location: employees.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $role = $_POST['role'];
    $stmt = $db->prepare('UPDATE users SET role = ? WHERE id = ?');
    $stmt->execute([$role, $id]);
    header('Location: employees.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle'])) {
    $id = $_POST['id'];
    $action = $_POST['action'];
    $password = $action === 'enable' ? '$2y$10$4q1J8Y9Z0k2L3m4N5o6P7q8R9s0T1u2V3w4X5y6Z7a8B9c0D1e2' : NULL;
    $stmt = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
    $stmt->execute([$password, $id]);
    header('Location: employees.php');
    exit;
}
?>
<h2>Сотрудники</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Email</th>
            <th>Роль</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $stmt = $db->query('SELECT * FROM users');
        while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $status = $user['password'] ? 'Активен' : 'Заблокирован';
            echo "<tr>
                <td>{$user['email']}</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='id' value='{$user['id']}'>
                        <input type='hidden' name='update' value='1'>
                        <select name='role' onchange='this.form.submit()'>
                            <option value='admin' " . ($user['role'] === 'admin' ? 'selected' : '') . ">Админ</option>
                            <option value='manager' " . ($user['role'] === 'manager' ? 'selected' : '') . ">Менеджер</option>
                            <option value='warehouse' " . ($user['role'] === 'warehouse' ? 'selected' : '') . ">Склад</option>
                        </select>
                    </form>
                </td>
                <td>$status</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='id' value='{$user['id']}'>
                        <input type='hidden' name='action' value='" . ($user['password'] ? 'disable' : 'enable') . "'>
                        <input type='hidden' name='toggle' value='1'>
                        <button type='submit' class='btn btn-sm " . ($user['password'] ? 'btn-danger' : 'btn-success') . "'>" . ($user['password'] ? 'Заблокировать' : 'Разблокировать') . "</button>
                    </form>
                </td>
            </tr>";
        }
        ?>
    </tbody>
</table>
<h3>Добавить сотрудника</h3>
<form method="POST">
    <input type="hidden" name="add" value="1">
    <input type="email" class="form-control mb-2" name="email" placeholder="Email" required>
    <input type="password" class="form-control mb-2" name="password" placeholder="Пароль" required>
    <select name="role" class="form-control mb-2">
        <option value="admin">Админ</option>
        <option value="manager">Менеджер</option>
        <option value="warehouse">Склад</option>
    </select>
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>
<?php require '../includes/footer.php'; ?>