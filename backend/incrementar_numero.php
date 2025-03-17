<?php
error_reporting(E_ALL & ~E_WARNING); // Reportar todos los errores excepto los warnings.
ini_set('display_errors', 1);

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    die(json_encode(['success' => false, 'error' => 'Usuario no autenticado']));
}

if (!isset($_SESSION['modulo'])) {
    die(json_encode(['success' => false, 'error' => 'Modulo no definido']));
}

require_once '../includes/db.php';

$usuario = $_SESSION['usuario'];
$modulo = $_SESSION['modulo'];

$sql = "SELECT numero FROM numeros WHERE usuario = '$usuario'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $numero = $row['numero'] + 1;
} else {
    $numero = 1;
    $sql_insert_usuario = "INSERT INTO numeros (usuario, numero) VALUES ('$usuario', 1)";
    $conn->query($sql_insert_usuario);
}

$sql_update_numero = "UPDATE numeros SET numero = $numero WHERE usuario = '$usuario'";
if ($conn->query($sql_update_numero) === TRUE) {
    $numero_con_modulo = $modulo . $numero;
    $sql_insert_atencion = "INSERT INTO atenciones (usuario, numero) VALUES ('$usuario', '$numero_con_modulo')";
    if ($conn->query($sql_insert_atencion) === TRUE) {
        echo json_encode(['success' => true, 'numero' => $numero_con_modulo]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Error al insertar atención: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Error al actualizar número: ' . $conn->error]);
}

$conn->close();
?>
