<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// obtener_numero.php
session_start();

header('Content-Type: application/json');

require_once '../includes/db.php';

// Obtener el número actual
$sql = "SELECT numero FROM numeros WHERE id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'numero' => $row['numero']]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se encontró el número']);
}

$conn->close();
?>