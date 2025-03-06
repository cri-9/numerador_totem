document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const errorMessage = document.getElementById('error-message');

    // Validar campos antes de enviar el formulario
    loginForm.addEventListener('submit', function (event) {
        const username = document.getElementById('usuario').value;
        const password = document.getElementById('password').value;

        if (!username || !password) {
            event.preventDefault();  // Evitar el envío del formulario
            errorMessage.textContent = 'Usuario y contraseña son requeridos.';
        } else {
            errorMessage.textContent = '';  // Limpiar mensaje de error si los campos están llenos
        }
    });

    // Mostrar mensaje de error si la autenticación falló
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('error')) {
        switch (urlParams.get('error')) {
            case 'campos_vacios':
                errorMessage.textContent = 'Usuario y contraseña son requeridos.';
                break;
            case 'conexion_ldap':
                errorMessage.textContent = 'Error al conectar con el servidor LDAP.';
                break;
            case 'credenciales_invalidas':
                errorMessage.textContent = 'Usuario o contraseña incorrectos.';
                break;
            default:
                errorMessage.textContent = 'Error desconocido. Inténtalo de nuevo.';
                break;
        }
    }
});