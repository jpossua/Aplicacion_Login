<?php
require 'config_session.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['idUser'])) {
    $_SESSION['error'] = "Acceso denegado: Debes iniciar sesión.";
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Aplicación Segura</title>
    <!-- Icono de la pagina -->
    <link rel="shortcut icon" href="https://iesplayamar.es/wp-content/uploads/2021/09/logo-ies-playamar.png" type="image/x-icon">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #fff;
        }

        @media (min-width: 992px) {
            body {
                overflow: hidden;
            }
        }
    </style>
</head>

<body>

    <button id="btnOscuro" type="button" class="btn btn-primary rounded-circle m-3 p-2 mt-3">🌙</button>
    <section>
        <div class="container py-5">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="img/login.svg"
                        class="img-fluid" alt="Welcome image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">

                    <!-- Título de bienvenida -->
                    <h2 class="mb-4"><i class="bi bi-check-circle-fill text-success"></i> ¡Bienvenido!</h2>

                    <!-- Información del usuario -->
                    <div class="alert alert-success">
                        <i class="bi bi-person-circle"></i>
                        <strong>Usuario:</strong> <?php echo htmlspecialchars($_SESSION['nombre'] . ' ' . $_SESSION['apellidos']); ?>
                    </div>

                    <!-- Card de información -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-shield-check"></i> Sesión Activa</h5>
                            <p class="card-text">Has iniciado sesión correctamente. Esta es la página de inicio protegida.</p>
                            <p class="card-text text-muted"><small>Si intentas entrar aquí sin loguearte, serás redirigido al login.</small></p>
                        </div>
                    </div>

                    <!-- Información de la sesión -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-info-circle"></i> Información de Seguridad</h5>
                            <ul class="list-unstyled mb-0">
                                <li><i class="bi bi-clock"></i> La sesión expira en 2 horas</li>
                                <li><i class="bi bi-arrow-repeat"></i> ID regenerado cada 20 minutos</li>
                                <li><i class="bi bi-shield-lock"></i> Cookies seguras con HttpOnly</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Botón de cerrar sesión -->
                    <a href="logout.php" class="btn btn-danger btn-lg btn-block">
                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                    </a>

                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <!-- Script para el botón de tema oscuro/claro -->
    <script src="validarDatos.js"></script>
</body>

</html>