<?php
echo "<h3>🔍 Проверка базы данных</h3>";

$db_path = _DIR_ . '/racer.db';
echo "📄 Путь к базе: " . realpath($db_path) . "<br>";

if (!file_exists($db_path)) {
    die("❌ Файл базы данных не найден.");
}

try {
    $pdo = new PDO('sqlite:' . $db_path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Успешное подключение к базе данных.<br>";

    // Проверка наличия таблицы users
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");
    $result = $stmt->fetch();

    if ($result) {
        echo "✅ Таблица <code>users</code> найдена.<br>";

        // Пробуем вывести одного пользователя
        $stmt = $pdo->query("SELECT id, email FROM users LIMIT 1");
        $user = $stmt->fetch();
        if ($user) {
            echo "👤 Первый пользователь: " . $user['email'] . "<br>";
        } else {
            echo "⚠️ Таблица пуста.<br>";
        }
    } else {
        echo "❌ Таблица <code>users</code> не найдена в базе.<br>";
    }

} catch (PDOException $e) {
    echo "❌ Ошибка подключения: " . $e->getMessage();
}
?>