<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
header('Content-Type: application/json');

require_once '../includes/db.php';

$usuario = $_SESSION['usuario'];
$modulo = $_SESSION['modulo'];

// Obtener el número actual del usuario
$sql = "SELECT numero FROM numeros WHERE usuario = '$usuario'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $numero_con_modulo = $modulo . ' - ' . $row['numero'];
    echo json_encode(['success' => true, 'numero' => $numero_con_modulo]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se encontró el número para el usuario']);
}

$conn->close();
?>