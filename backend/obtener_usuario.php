<?php
// obtener_usuario.php
session_start(); // Iniciar la sesión

header('Content-Type: application/json');

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'error' => 'Usuario no autenticado']);
    exit;
}

// Devolver el nombre de usuario
echo json_encode(['success' => true, 'usuario' => $_SESSION['usuario']]);
?>