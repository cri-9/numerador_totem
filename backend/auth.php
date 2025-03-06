<?php
// Datos del servidor Active Directory
$domain = 'mineduc.cl';  // Cambia esto por tu dominio
$port = 389;  // Puerto LDAP por defecto

// Obtener credenciales del formulario
$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Verificar si las credenciales están vacías
if (empty($usuario) || empty($password)) {
    header("Location: ../login.php?error=campos_vacios");
    exit();
}

// Conectar al servidor LDAP
$ldapconn = ldap_connect($domain, $port);
if (!$ldapconn) {
    header("Location: ../login.php?error=conexion_ldap");
    exit();
}

// Configurar opciones de LDAP
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);

// Intentar autenticar al usuario
$ldapbind = @ldap_bind($ldapconn, "$usuario@$domain", $password);

if ($ldapbind) {
    // Autenticación exitosa
    session_start();
    $_SESSION['usuario'] = $usuario;
    header("Location: ../ventana_emergente.html");
    exit();
} else {
    // Autenticación fallida
    header("Location: ../login.php?error=credenciales_invalidas");
    exit();
}
?>