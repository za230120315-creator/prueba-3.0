<?php
$servername = "localhost";
$username = "root";
$password = "admin1306";
$database = "metalsol"; // Asegúrate que tu base se llama así

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
