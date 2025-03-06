<?php
$servername = "localhost";// Si usas XAMPP, generalmente es "localhost"
$username = ""; // Cambia esto si tienes otro usuario en MySQL
$password = ""; // Si estás en XAMPP, normalmente la contraseña está vacía
$database = "sistema_numeros"; // Nombre correcto de tu base de datos

$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

