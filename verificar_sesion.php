<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); //Evita que el navegador guarde en caché la página actual
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); //Evita que el naveador guarde la respuesta en Caché
header('Content-Type: application/json'); //Refueza NO-CACHE para navegadores que no soportan Cache-Control

if (isset($_SESSION['usuario'])) {
    echo json_encode([
        "sesion_activa" => true,
        "nombre_completo" => $_SESSION['nombre_completo'] ?? $_SESSION['usuario']
    ]);
} else {
    echo json_encode(["sesion_activa" => false]);
}
?>
