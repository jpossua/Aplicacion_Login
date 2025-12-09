<?php
// Iniciar sesión: session_start() inicia una sesión o reanuda una sesión existente
// Iniciar sesión usando la configuración segura
require 'config_session.php';

if (!isset($_POST["csrf_token"]) || !isset($_SESSION["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    $_SESSION['error'] = "Token CSRF no válido";
    header("Location: index.php");
    die("Solicitud no válida. Token CSRF no coincide.");
}
// Si el token CSRF es válido, el script debe continuar con la lógica de autenticación a continuación.
// No se necesita redirección ni salida en la parte "else" de la comprobación CSRF.
// El proceso de autenticación gestionará la redirección a index.php (en caso de error) o a inicio.php (en caso de éxito).

if (isset($_POST['idUser']) && isset($_POST['password'])) {
    $_SESSION['idUser'] = $_POST['idUser'];
    $_SESSION['password'] = $_POST['password'];
} else {
    $_SESSION['error'] = "Debes iniciar sesión";
    header("Location: index.php");
    exit();
}

// Variables de la base de datos
$host = "localhost";
$user = "LoginPhp";
$pass = "95f90HZJy3sb";
$db = "login-php";

$mysqli = null; // Initialize $mysqli to null

// Conectar a la base de datos
try {
    $mysqli = new mysqli($host, $user, $pass, $db);
} catch (mysqli_sql_exception $e) {
    $_SESSION['error'] = "Error de conexión: " . $e->getMessage();
    header("Location: index.php");
    exit();
}

// Comprobar la conexión: $mysqli->connect_error es un atributo booleano que contiene el error de la conexión
if ($mysqli->connect_error) {
    $_SESSION['error'] = "Error de conexión: " . $mysqli->connect_errno;
    header("Location: index.php");
    exit();
} else {
    $usuario = htmlspecialchars($_POST['idUser']);
    $password = htmlspecialchars($_POST['password']);

    // 1. Preparar la consulta con marcadores de posición
    $cadenaSQL = "SELECT * FROM usuarios WHERE idUser = ?"; // hay un "hueco" ? para el idUser particular

    // 2. Preparar la sentencia
    if ($comando = $mysqli->prepare($cadenaSQL)) {          // se anticipa la query
        $comando->bind_param("s", $usuario);      // se hace un bind con el (o los) datos concretos

        // 3. Ejecutar la consulta
        if ($comando->execute()) {                          // se ejecuta la consulta
            $result = $comando->get_result();

            // proceso del resultado obtenido de la ejecución de la consulta 
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Si el usuario existe, comprobamos la contraseña

                // Generar hash (Descomentar para ver el hash y actualizar la BBDD)
                // echo "Hash: " . password_hash($password, PASSWORD_DEFAULT);

                // if ($row['password'] == $password) { // CODIGO ANTIGUO (INSEGURO)

                if (password_verify($password, $row['password'])) {
                    $_SESSION['idUser'] = $usuario;
                    $_SESSION['password'] = $password;
                    $_SESSION['nombre'] = $row['nombre'];
                    $_SESSION['apellidos'] = $row['apellidos'];
                    $mysqli->close(); // Cerrar la conexión despues de redirigir
                    // Redirigir a inicio.php si la conexión es exitosa y se han seteado las variables de sesión
                    header("Location: inicio.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Contraseña incorrecta";
                    $mysqli->close(); // Cerrar la conexión despues de redirigir
                    header("Location: index.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = "Usuario no encontrado";
                $mysqli->close(); // Cerrar la conexión despues de redirigir
                header("Location: index.php");
                exit();
            }
        } else {
            echo "Error: " . $comando->error;              // se avisa del error (donde sea pertinente)
        }

        // 4. Cerrar la query
        $comando->close();                                 // se cierra la query
    } else {
        echo "Error al preparar la consulta: " . $mysqli->error; // algun tipo de error a depurar en fase de Dev
    }

    /* CODIGO ANTIGUO COMENTADO
    // Primero comprobamos si existe el usuario
    $querySQL = "SELECT * FROM usuarios WHERE idUser = '$usuario'";
    $result = $mysqli->query($querySQL);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Si el usuario existe, comprobamos la contraseña
        if ($row['password'] == $password) {
            $_SESSION['idUser'] = $usuario;
            $_SESSION['password'] = $password;
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellidos'] = $row['apellidos'];
            $mysqli->close(); // Cerrar la conexión despues de redirigir
            // Redirigir a inicio.php si la conexión es exitosa y se han seteado las variables de sesión
            header("Location: inicio.php");
            exit();
        } else {
            $_SESSION['error'] = "Contraseña incorrecta";
            $mysqli->close(); // Cerrar la conexión despues de redirigir
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Usuario no encontrado";
        $mysqli->close(); // Cerrar la conexión despues de redirigir
        header("Location: index.php");
        exit();
    }
    */
}
