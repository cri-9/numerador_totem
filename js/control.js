$(document).ready(function() {
    // Llamar a la función para obtener el nombre de usuario
    obtenerNombreUsuario();

    // Generar número
    $('#generarNumero').click(function() {
        // Obtener el nombre de usuario
        var usuario = $('#nombreUsuario').text().replace('Usuario: ', ''); // Extrae el nombre de usuario

        $.ajax({
            url: "backend/incrementar_numero.php",
            type: "POST",
            data: { usuario: usuario }, // Corrige el valor enviado
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $("#numeroActual").text(response.numero);
                } else {
                    console.error("Error en el servidor:", response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la petición AJAX:", xhr.responseText);
            }
        });
    });

    // Actualizar número manualmente
    $('#actualizarNumero').click(function() {
        var usuario = $('#nombreUsuario').text().replace('Usuario: ', ''); // Extrae el nombre de usuario
        var nuevoNumero = $('#nuevoNumero').val();

        if (nuevoNumero === '') {
            alert('Por favor, ingresa un número.');
            return;
        }

        $.ajax({
            url: 'backend/actualizar_numero.php',
            method: 'POST',
            dataType: 'json',
            data: {
                usuario: usuario,
                nuevoNumero: nuevoNumero
            },
            success: function(response) {
                if (response.success) {
                    $('#numeroActual').text(nuevoNumero);
                    $('#nuevoNumero').val('');
                } else {
                    alert('Error: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                alert('Error en la solicitud AJAX: ' + error);
            }
        });
    });

    // Obtener el nombre de usuario
    function obtenerNombreUsuario() {
        $.ajax({
            url: 'backend/obtener_usuario.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#nombreUsuario').text('Usuario: ' + response.usuario);
                } else {
                    if (response.error === 'Usuario no autenticado') {
                        window.location.href = 'login.php';
                    } else {
                        console.error('Error: ' + response.error);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX: ' + error);
            }
        });
    }

    // Obtener último número
    function obtenerUltimoNumero() {
        $.ajax({
            url: 'backend/obtener_numero.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#numeroActual').text(response.numero);
                } else {
                    console.error('Error al obtener el último número:', response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la petición AJAX:', error);
            }
        });
    }

    obtenerUltimoNumero(); // Llama a la función al cargar la página
});

// ✅ Agrega la función cerrarVentana()
function cerrarVentana() {
    window.close();
}
