<?php
$password = 'password';
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Хэш: $hash<br>";
echo "Проверка: " . (password_verify($password, '$2y$10$4q1J8Y9Z0k2L3m4N5o6P7q8R9s0T1u2V3w4X5y6Z7a8B9c0D1e2') ? 'Верно' : 'Неверно');
?>