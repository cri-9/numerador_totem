<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrando sesión...</title>
    <script>
        // Guardar en localStorage que la sesión se cerró
        localStorage.setItem('cerrarPantalla', 'true');

        // Intentar cerrar la ventana actual
        setTimeout(() => {
            window.close();
        }, 1000);

        // Si no se cierra, redirigir a login.php
        setTimeout(() => {
            window.location.href = "login.php";
        }, 2000);
    </script>
</head>
<body>
    <p>Sesión cerrada correctamente. Cerrando ventanas...</p>
</body>
</html>

