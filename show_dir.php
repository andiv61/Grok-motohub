<?php
echo "<h3>📂 Содержимое текущей директории</h3>";
$files = scandir(__DIR__);

foreach ($files as $file) {
    echo $file . "<br>";
}
?>