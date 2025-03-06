<?php
// Actualizar_numero.php
session_start();

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

if (!isset($_SESSION['usuario'])) {
    http_response_code(401); // No autorizado
    die(json_encode(['success' => false, 'error' => 'Usuario no autenticado']));
}

require_once '../includes/db.php';

$usuario = $_POST['usuario'];
$nuevoNumero = $_POST['nuevoNumero'];

// Actualizar nuevo número en la tabla numeros
$sql_update_numero = "UPDATE numeros SET numero = ".$conn->real_escape_string($nuevoNumero)." WHERE id = 1";

if ($conn->query($sql_update_numero) === TRUE) {
    // Insertar la atención en la tabla atenciones
    $sql_insert_atencion = "INSERT INTO atenciones (usuario, numero) VALUES ('$usuario', $nuevoNumero)";

    if ($conn->query($sql_insert_atencion) === TRUE) {
        echo json_encode(['success' => true, 'numero' => $nuevoNumero]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al insertar atención: ' . $conn->error]);
    }

} else {
    echo json_encode(['success' => false, 'error' => 'Error al insertar número: ' . $conn->error]);
}

$conn->close();
?>