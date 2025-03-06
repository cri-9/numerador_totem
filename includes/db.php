<?php
$servername = "lnumerador_db";// Si usas XAMPP, generalmente es "localhost"
$username = "if0_38461337"; // Cambia esto si tienes otro usuario en MySQL
$password = "SuHueiF4vC"; // Si estás en XAMPP, normalmente la contraseña está vacía
$database = "if0_38461337_numerador_db"; // Nombre correcto de tu base de datos

$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>

