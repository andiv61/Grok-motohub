<?php
$path = realpath(__DIR__ . '/../racer.db');
echo "🔍 Абсолютный путь к базе: $path<br>";

if (file_exists($path)) {
    echo "✅ База найдена.<br>";
    try {
        $pdo = new PDO('sqlite:' . $path);
        $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

        echo "📋 Таблицы в базе: <pre>" . print_r($tables, true) . "</pre>";
    } catch (PDOException $e) {
        echo "❌ Ошибка подключения: " . $e->getMessage();
    }
} else {
    echo "❌ База не найдена по пути $path";
}
?>