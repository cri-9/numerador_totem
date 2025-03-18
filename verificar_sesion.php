<?php
session_start();

// Devuelve un JSON con el estado de la sesión
echo json_encode(["sesion_activa" => isset($_SESSION['usuario'])]);
?>
