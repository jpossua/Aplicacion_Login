/**
 * Validar datos del formulario
 *  El ID del usuario: entre 8 y 15 caracteres
 * La contraseña del usuario: entre 6 y 15 caracteres. Haz que la contraseña tenga, obligatoriamente letras mayúsculas, minúsculas, 
 * caracteres especiales (menos pero no ‘ “ \ / < > = ( ) u otros caracteres que puedan ser parte de un script malicioso)
 * True si los datos son validos, false en caso contrario
 */

// Añadimos un 'listener' al evento 'submit' del formulario.
// Esto nos permite ejecutar código antes de que el formulario se envíe.
document.getElementById('form1').addEventListener("submit", function (event) {
    // Obtenemos los valores del formulario
    const idUser = document.getElementById('idUser').value;
    const password = document.getElementById('password').value;
    // Si la función validarDatos() devuelve false, prevenimos el envío.
    if (!validarDatos(idUser, password)) {
        event.preventDefault(); // Parar el submit por defecto
    }
    // Si la función validarDatos() devuelve true, ocultamos los errores
    else {
        ocultarError('idUserHelp');
        ocultarError('passwordHelp');
    }
});

// Función que valida los datos del formulario
function validarDatos(idUser, password) {
    let valido = true;

    // Longitud entre 8 y 15 caracteres para el idUser
    if (idUser.length < 8 || idUser.length > 15) {
        valido = false;
        mostrarError('idUserHelp', 'El idUser debe tener entre 8 y 15 caracteres');
    }

    /* Longitud entre 6 y 15 caracteres para la contraseña y debe contener mayusculas, minusculas, números y caracteres especiales (menos pero no ‘ “ \ / < > = ( )
     * u otros caracteres que puedan ser parte de un script malicioso)
     */
    if (password.length < 6 || password.length > 15 || !/[A-Za-z0-9]/.test(password) || !/[!@#$%^&*_+=\-\[\]{};':",.?]/.test(password) || /[‘“\\/<>=()]/.test(password)) {
        valido = false;
        mostrarError('passwordHelp', `La contraseña debe tener entre 6 y 15 caracteres y debe contener mayusculas, minusculas, 
            números y caracteres especiales, menos ‘ “ \ / < > = ( )`);
    }

    return valido;
}
function mostrarError(id, error) {
    document.getElementById(id).textContent = error;
    document.getElementById(id).style.visibility = "visible";
}

function ocultarError(id) {
    document.getElementById(id).style.visibility = "hidden";
}
