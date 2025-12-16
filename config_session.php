<?php
// Configuración de parámetros de cookie de sesión
session_set_cookie_params([
    'lifetime' => 3600,                     // Limita el tiempo de las cookies (opcional)
    'path' => '/',                          // Activa para todo el dominio
    // 'domain' => 'tu-dominio.com',           // Desactivado para localhost. Descomentar y establecer para producción.
    //'secure' => isset($_SERVER['HTTPS']),   // Solo si HTTPS esta disponible (para el despliegue, no en desarrollos).
    'httponly' => true,                     // No accesible via JavaScript
    'samesite' => 'Strict',                 // Previenen el ataque CSRF
]);

// 1. Iniciar la sesión
session_start();

// ============================================
// LÍMITE ABSOLUTO DE SESIÓN: 2 HORAS
// ============================================
// Tiempo máximo de vida de la sesión en segundos (2 horas = 7200 segundos)
$session_max_lifetime = 7200;

// Almacenar el timestamp de creación de la sesión si no existe
if (!isset($_SESSION['session_created'])) {
    $_SESSION['session_created'] = time();
}

// Verificar si la sesión ha superado el límite de 2 horas
if (time() - $_SESSION['session_created'] >= $session_max_lifetime) {
    // Limpiar todas las variables de sesión
    session_unset();
    // Destruir la sesión
    session_destroy();
    // Redirigir al login con mensaje de sesión expirada
    header("Location: index.php?expired=1");
    exit();
}

// ============================================
// REGENERACIÓN DE ID DE SESIÓN
// ============================================
// 2. Define el intervalo en segundos (por ejemplo, 1200 segundos = 20 minutos)
$regenerate_interval = 1200;

// 3. Almacena el tiempo de la última regeneración si no existe
if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
}

// 4. Verifica y regenera si es necesario
if (time() - $_SESSION['last_regeneration'] >= $regenerate_interval) {
    // Regenera el ID de sesión y elimina los datos de la sesión antigua
    session_regenerate_id(true);
    // Actualiza el timestamp para el próximo intervalo
    $_SESSION['last_regeneration'] = time();
}

// 5. Generación de un CSRF Token
if (empty($_SESSION['csrf_token'])) {
    // Creación de un CSRF Token: generar un token aleatorio de 64 bytes y luego hace una codificación hashing
    $csrf_token = bin2hex(openssl_random_pseudo_bytes(64));

    // Resguardo del CSRF Token en una sesión
    $_SESSION['csrf_token'] = $csrf_token;
}
