<?php
session_start(); // Iniciar sesión
header('Content-Type: application/json');

error_log("Sesión actual: " . print_r($_SESSION, true)); // Registrará el estado de la sesión

if (!isset($_SESSION['usuario'])) {
    error_log("Usuario no autenticado"); // Registrará si no hay usuario
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado']);
    exit;
}

echo json_encode(['success' => true, 'usuario' => $_SESSION['usuario']]);
?>