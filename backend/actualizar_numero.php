<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Actualizar_numero.php
session_start();

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

if (!isset($_SESSION['usuario'])) {
    http_response_code(401); // No autorizado
    die(json_encode(['success' => false, 'error' => 'Usuario no autenticado']));
}

require_once '../includes/db.php';

$usuario = $_SESSION['usuario'];
$modulo = $_SESSION['modulo'];
$nuevoNumero = $_POST['nuevoNumero'];

// Actualizar el número en la tabla numeros para el usuario
$sql_update_numero = "UPDATE numeros SET numero = " . $conn->real_escape_string($nuevoNumero) . " WHERE usuario = '$usuario'";

if ($conn->query($sql_update_numero) === TRUE) {
    // Insertar la atención en la tabla atenciones con el módulo
    $numero_con_modulo = $modulo . $nuevoNumero;
    $sql_insert_atencion = "INSERT INTO atenciones (usuario, numero) VALUES ('$usuario', '$numero_con_modulo')";

    if ($conn->query($sql_insert_atencion) === TRUE) {
        echo json_encode(['success' => true, 'numero' => $numero_con_modulo]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al insertar atención: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Error al insertar número: ' . $conn->error]);
}

$conn->close();
?>