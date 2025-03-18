<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['usuario'])) {
    echo json_encode([
        "sesion_activa" => true,
        "usuario" => $_SESSION['usuario'],
        "nombre_completo" => $_SESSION['nombre_completo'] ?? $_SESSION['usuario'] // Si no hay nombre, usa usuario
    ]);
} else {
    echo json_encode(["sesion_activa" => false]);
}
?>
