<?php
$pdo = new PDO('sqlite:' . __DIR__ . '/../racer.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
