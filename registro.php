<?php
// Cargar configuración de sesión para acceder al token CSRF y mensajes
require 'config_session.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
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

        /* Restaurar visibilidad: oculta para el texto del formulario para que JS pueda alternarla a visible */
        .form-text {
            visibility: hidden;
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
                        class="img-fluid" alt="Registration image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">

                    <!-- Título del formulario -->
                    <h2 class="mb-4"><i class="bi bi-person-plus-fill"></i> Registro de Usuario</h2>

                    <!-- Mostrar errores PHP -->
                    <?php
                    if (isset($_SESSION['registro_error'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['registro_error'] . '</div>';
                        unset($_SESSION['registro_error']);
                    }
                    ?>

                    <!-- Información sobre la aprobación -->
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Tu cuenta estará pendiente de aprobación por el administrador.
                    </div>

                    <form action="procesar_registro.php" method="POST" id="formRegistro">

                        <!-- ID de Usuario -->
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" id="idUser" name="idUser" placeholder="correo@ejemplo.com" required />
                            <label for="idUser">Id Usuario (Email)</label>
                        </div>
                        <!-- Contenedor del mensaje de error. JS alterna la visibilidad. -->
                        <div id="idUserHelp" class="form-text text-danger mb-3">Errores aqui</div>

                        <!-- Campo de contraseña -->
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
                            <label for="password">Contraseña</label>
                        </div>
                        <!-- Contenedor del mensaje de error. JS alterna la visibilidad. -->
                        <div id="passwordHelp" class="form-text text-danger mb-3">Errores aqui</div>

                        <!-- Nombre -->
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" required />
                            <label for="nombre">Nombre</label>
                        </div>

                        <!-- Apellidos -->
                        <div class="form-floating mb-4">
                            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Tus apellidos" required />
                            <label for="apellidos">Apellidos</label>
                        </div>

                        <!-- CSRF Token -->
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'] ?? ''); ?>">

                        <!-- Botón de envío -->
                        <button type="submit" class="btn btn-success btn-lg btn-block">Registrarse</button>

                        <!-- Enlace para volver al login -->
                        <p class="text-center mt-3">¿Ya tienes cuenta? <a href="index.php">Iniciar Sesión</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <!-- Script para validar los datos del formulario y cambiar el color de fondo -->
    <script src="validarDatos.js"></script>
</body>

</html>