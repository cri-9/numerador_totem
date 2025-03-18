<?php 
// Datos del servidor Active Directory
$domain = 'mineduc.cl'; // Cambia esto por tu dominio
$port = 389; // Puerto LDAP por defecto

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
    $error = ldap_error($ldapconn);
    header("Location: ../login.php?error=conexion_ldap&detalle=$error");
    exit();
}

// Configurar opciones de LDAP
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ldapconn, LDAP_OPT_NETWORK_TIMEOUT, 10);

// Intentar autenticar al usuario
$ldapbind = @ldap_bind($ldapconn, "$usuario@$domain", $password);

// Verificar si la autenticación fue exitosa
if ($ldapbind) {
    session_start();
    $_SESSION['usuario'] = $usuario;

    // Buscar el nombre completo del usuario en LDAP
    $search_base = "dc=mineduc,dc=cl"; // Ajusta esto según tu estructura LDAP
    $search_filter = "(sAMAccountName=$usuario)";
    $search = ldap_search($ldapconn, $search_base, $search_filter, ["displayName"]);
    $entries = ldap_get_entries($ldapconn, $search);

    // Si se encuentra el nombre en LDAP, guardarlo en la sesión
    if ($entries["count"] > 0 && isset($entries[0]["displayname"][0])) {
        $_SESSION['nombre_completo'] = $entries[0]["displayname"][0];
    } else {
        $_SESSION['nombre_completo'] = ucfirst($usuario); // Si no hay nombre, usar usuario con primera letra en mayúscula
    }

    // Asignar letras fijas
    switch ($usuario) {
        case 'usuarioA':
            $_SESSION['modulo'] = 'A';
            break;
        case 'usuarioB':
            $_SESSION['modulo'] = 'B';
            break;
        case 'usuarioC':
            $_SESSION['modulo'] = 'C';
            break;
        case 'usuarioD':
            $_SESSION['modulo'] = 'D';
            break;
        default:
            $_SESSION['modulo'] = strtoupper(substr($usuario, 0, 1)); // Obtener la primera letra y convertirla a mayúscula
    }

    header("Location: ../ventana_emergente.html");
    exit();
} else {
    $ldap_error = ldap_error($ldapconn);
    header("Location: ../login.php?error=credenciales_invalidas&detalle=$ldap_error");
    exit();
}
?>
