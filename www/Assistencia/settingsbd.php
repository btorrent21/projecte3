<?php
$servername = "192.168.10.202";
$username = "admin";
$password = "12345aA";
$database = "insviladegracia";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
