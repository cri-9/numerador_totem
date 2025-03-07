<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_numeros";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
echo "Conexión exitosa a la base de datos.";
?>
