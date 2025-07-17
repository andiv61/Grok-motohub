<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "racer_motorcycles";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>