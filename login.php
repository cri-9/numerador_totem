<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Corporativo</title>
    <link rel="stylesheet" href="css/login_styles.css">
    <script src="js/login.js" defer></script>
</head>
<body>
    <img src="img/mineduc.jpg" alt="Logo Corporativo" id="logo-login">
    <div class="login-container">
        <h1>Autenticación</h1>
        <form id="loginForm" action="backend/auth.php" method="post">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Ingresar</button>
        </form>
        <p id="error-message" class="error-message"></p>
    </div>
</body>
</html>