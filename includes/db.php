<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
try {
    $db = new PDO('sqlite:' . __DIR__ . '/../db/racer.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>