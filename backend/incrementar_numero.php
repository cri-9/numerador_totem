<?php

// incrementar_numero.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

header('Content-Type: application/json');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    die(json_encode(['success' => false, 'error' => 'Usuario no autenticado']));
}

require_once '../includes/db.php'; // Verifica que esta ruta sea correcta

// Verifica si la conexión es correcta
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Error de conexión: ' . $conn->connect_error]));
}

// Verifica que se envió el usuario correctamente
if (!isset($_POST['usuario']) || empty($_POST['usuario'])) {
    die(json_encode(['success' => false, 'error' => 'Usuario no proporcionado']));
}

$usuario = $conn->real_escape_string($_POST['usuario']); // Evita inyección SQL

// Obtener el número actual
$sql = "SELECT numero FROM numeros WHERE id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $numero = $row['numero'] + 1;
} else {
    $numero = 1;
}

// Actualizar el número en la base de datos
$sql_update_numero = "UPDATE numeros SET numero = $numero WHERE id = 1";
if ($conn->query($sql_update_numero) === TRUE) {
    // Insertar la atención en la tabla atenciones
    $sql_insert_atencion = "INSERT INTO atenciones (usuario, numero) VALUES ('$usuario', $numero)";
    if ($conn->query($sql_insert_atencion) === TRUE) {
        echo json_encode(['success' => true, 'numero' => $numero]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al insertar atención: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Error al actualizar número: ' . $conn->error]);
}

$conn->close();
?>
