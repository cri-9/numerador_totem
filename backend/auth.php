<?php

// Datos del servidor Active Directory
$domain = 'mineduc.cl';  // Cambia esto por tu dominio
$port = 389;  // Puerto LDAP por defecto
 // Puerto LDAP por defecto

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
    // Mostrar detalles del error de conexión LDAP
    $error = ldap_error($ldapconn);
    header("Location: ../login.php?error=conexion_ldap&detalle=$error");
    exit();
}


// Configurar opciones de LDAP
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3); // Usar versión 3 del protocolo LDAP
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0); // Evitar redirecciones (referrals) en LDAP
ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 10); // Establecer tiempo de espera a 10 segundos


// Intentar autenticar al usuario
$ldapbind = @ldap_bind($ldapconn, "$usuario@$domain", $password);

// Verificar si la autenticación fue exitosa
if ($ldapbind) {
    // Autenticación exitosa
    session_start();
    $_SESSION['usuario'] = $usuario;
    header("Location: ../ventana_emergente.html");
    exit();
} else {
    // Autenticación fallida, obtener error LDAP
    $ldap_error = ldap_error($ldapconn);
    header("Location: ../login.php?error=credenciales_invalidas&detalle=$ldap_error");
    exit();
}

?>