function obtenerNombreUsuario() {
	console.log("Intentando obtener el nombre de usuario...");

	$.ajax({
		url: 'backend/obtener_usuario.php', // Verifica que esta URL sea correcta
		method: 'GET',
		dataType: 'json',
		success: function(response) {
			console.log("Respuesta recibida:", response);

			if (response.success) {
				$('#nombreUsuario').text('Usuario: ' + response.usuario);
			} else {
				console.error('Error en el servidor:', response.error);
				if (response.error === 'Usuario no autenticado') {
					window.location.href = 'login.php'; // Redirigir si no está autenticado
				}
			}
		},
		error: function(xhr, status, error) {
			console.error('Error en la solicitud AJAX:', error);
			console.log('Detalles de error:', xhr.responseText); // Mostramos más información
		}
	});
}

