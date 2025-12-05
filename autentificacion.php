<?php
// Iniciar sesión: session_start() inicia una sesión o reanuda una sesión existente
session_start();

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
$user = "root"; // Inseguro *********
$pass = ""; // Inseguro *********
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
    $mysqli->close(); // Cerrar la conexión al final del script si no hubo exit
}
