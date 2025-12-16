<?php
// ============================================
// PROCESAR REGISTRO DE USUARIO
// ============================================
// Este archivo procesa el formulario de registro de nuevos usuarios.
// Los nuevos usuarios se crean con admitido = false (pendiente de aprobación)

require 'config_session.php';

// ============================================
// VERIFICACIÓN DEL TOKEN CSRF
// ============================================
if (!isset($_POST["csrf_token"]) || !isset($_SESSION["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
    $_SESSION['registro_error'] = "Token CSRF no válido";
    header("Location: registro.php");
    exit();
}

// Obtener y sanitizar los datos del formulario
$idUser = htmlspecialchars(trim($_POST['idUser'] ?? ''));
$password = $_POST['password'] ?? '';
$nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''));
$apellidos = htmlspecialchars(trim($_POST['apellidos'] ?? ''));

// ============================================
// VALIDACIÓN DEL SERVIDOR
// ============================================
// Es importante validar también en el servidor, no solo en el cliente
$errores = [];

// Validar longitud del idUser (entre 8 y 15 caracteres)
if (strlen($idUser) < 8 || strlen($idUser) > 15) {
    $errores[] = "El ID de usuario debe tener entre 8 y 15 caracteres.";
}

// Validar longitud de la contraseña (entre 8 y 15 caracteres)
if (strlen($password) < 8 || strlen($password) > 15) {
    $errores[] = "La contraseña debe tener entre 8 y 15 caracteres.";
}

// Validar que la contraseña tenga mayúsculas
if (!preg_match('/[A-Z]/', $password)) {
    $errores[] = "La contraseña debe contener al menos una mayúscula.";
}

// Validar que la contraseña tenga minúsculas
if (!preg_match('/[a-z]/', $password)) {
    $errores[] = "La contraseña debe contener al menos una minúscula.";
}

// Validar que la contraseña tenga números
if (!preg_match('/[0-9]/', $password)) {
    $errores[] = "La contraseña debe contener al menos un número.";
}

// Validar que la contraseña tenga caracteres especiales permitidos
if (!preg_match('/[!@#$%^&*_+=\-\[\]{};:,.?]/', $password)) {
    $errores[] = "La contraseña debe contener al menos un carácter especial: !@#$%^&*_+-[]{}:,.?";
}

// Validar que NO contenga caracteres peligrosos para evitar inyecciones
if (preg_match('/[\'\"\\\\\/\<\>=()]/', $password)) {
    $errores[] = "La contraseña contiene caracteres no permitidos: ' \" \\ / < > = ( )";
}

// Validar nombre y apellidos
if (empty($nombre)) {
    $errores[] = "El nombre es obligatorio.";
}
if (empty($apellidos)) {
    $errores[] = "Los apellidos son obligatorios.";
}

// Si hay errores de validación, mostrarlos
if (!empty($errores)) {
    $_SESSION['registro_error'] = implode("<br>", $errores);
    header("Location: registro.php");
    exit();
}

// ============================================
// CONEXIÓN A LA BASE DE DATOS
// ============================================
$host = "localhost";
$user = "LoginPhp";
$pass = "95f90HZJy3sb";
$db = "login-php";

try {
    $mysqli = new mysqli($host, $user, $pass, $db);
} catch (mysqli_sql_exception $e) {
    $_SESSION['registro_error'] = "Error de conexión: " . $e->getMessage();
    header("Location: registro.php");
    exit();
}

if ($mysqli->connect_error) {
    $_SESSION['registro_error'] = "Error de conexión: " . $mysqli->connect_errno;
    header("Location: registro.php");
    exit();
}

// ============================================
// VERIFICAR SI EL USUARIO YA EXISTE
// ============================================
$checkSQL = "SELECT idUser FROM usuarios WHERE idUser = ?";
$checkStmt = $mysqli->prepare($checkSQL);
$checkStmt->bind_param("s", $idUser);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    $_SESSION['registro_error'] = "El ID de usuario ya está en uso. Por favor, elige otro.";
    $checkStmt->close();
    $mysqli->close();
    header("Location: registro.php");
    exit();
}
$checkStmt->close();

// ============================================
// INSERTAR NUEVO USUARIO
// ============================================
// Hashear la contraseña de forma segura
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insertar con admitido = 0 (false) - pendiente de aprobación por admin
$insertSQL = "INSERT INTO usuarios (idUser, password, nombre, apellidos, admitido) VALUES (?, ?, ?, ?, 0)";
$insertStmt = $mysqli->prepare($insertSQL);
$insertStmt->bind_param("ssss", $idUser, $passwordHash, $nombre, $apellidos);

if ($insertStmt->execute()) {
    $_SESSION['registro_exito'] = "¡Registro exitoso! Tu cuenta está pendiente de aprobación por el administrador.";
    $insertStmt->close();
    $mysqli->close();
    header("Location: index.php");
    exit();
} else {
    $_SESSION['registro_error'] = "Error al registrar: " . $insertStmt->error;
    $insertStmt->close();
    $mysqli->close();
    header("Location: registro.php");
    exit();
}
