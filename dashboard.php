<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idUser'])) {
    $_SESSION['error'] = "Debes iniciar sesión para acceder al panel.";
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Panel de Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Aplicación Segura</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link text-white">Hola, <?php echo htmlspecialchars($_SESSION['idUser']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white ms-2" href="logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card">
            <div class="card-body text-center">
                <h1 class="display-4">¡Bienvenido al Panel de Control!</h1>
                <p class="lead">Has iniciado sesión de forma segura.</p>
                <hr class="my-4">
                <p>Aquí iría el contenido protegido de tu aplicación.</p>
                <a class="btn btn-primary btn-lg" href="#" role="button">Ver más</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>