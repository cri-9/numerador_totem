<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "sistema_numeros";

	// Crear conexión
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Verificar conexión
	if ($conn->connect_error) {
		http_response_code(500); // Error del servidor
		die(json_encode(['success' => false, 'error' => 'Error de conexión: ' . $conn->connect_error]));
	}
?>
