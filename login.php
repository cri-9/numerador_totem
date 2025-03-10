<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Corporativo</title>
    <link rel="stylesheet" href="css/login_styles.css">
    <script src="js/login.js" defer></script>
</head>
<div class="login-container">
<body>


<img src="img/mineduc.jpg" alt="Logo Corporativo" id="logo-login">
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
    

<!--Footer-->
<footer id="container_footer">
        <div id="mi-contenedor_footer">
            <section>
                <div id="barra_footer">
                    <a href="https://mineduc.cl" class="enlace-mineduc" target="_blank">Ministerio de Educación</a>
                </div>
            </section>
            
            <!--Redes sociales-->
            <div class="redes-sociales">
                <a href="http://www.facebook.com/mineduc" target="_blank">
                    <img src="img_redes/facebook.png" alt="Facebook">
                </a>
                <a href="http://twitter.com/mineduc" target="_blank">
                    <img src="img_redes/x.png" alt="Twitter">
                </a>
                <a href="https://www.instagram.com/mineducchile" target="_blank">
                    <img src="img_redes/instagram.png" alt="Instagram">
                </a>
                <a href="https://www.youtube.com/user/mineducchile" target="_blank">
                    <img src="img_redes/youtube.png" alt="YouTube">
                </a>
            </div>
        </div>
    </footer>
    </div>
</body>
</html>