<?php
$servername = "localhost"; // Si usas XAMPP, generalmente es "localhost"
$username = "root"; // Cambia esto si tienes otro usuario en MySQL
$password = ""; // Si estás en XAMPP, normalmente la contraseña está vacía
$database = "numerador"; // Nombre correcto de tu base de datos

$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

