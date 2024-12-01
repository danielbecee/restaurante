<?php
// Iniciar la sesión
session_start();

// Validar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_camarero'])) {
    header('Location: ../login.php'); // ajustar la ruta según sea necesario
    exit;
}
$id_camarero = $_SESSION['id_camarero'];

$nombreUsuario = htmlspecialchars($_SESSION['nombre']); // Escapar nombre de usuario para evitar XSS
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Opción</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="background-color: #548c94;">
    <!-- Header -->
    <header class="bg-light py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <span class="font-weight-bold">Bienvenido, <?php echo $nombreUsuario; ?></span>
            <a href="../historial.php" class="btn btn-secondary btn-sm"><i class="fas fa-history"></i> Historial</a>
            <form action="../logout.php" method="POST">
                <button type="submit" class="btn btn-danger btn-sm">Cerrar sesión</button>
            </form>
        </div>
    </header>

    <!-- Botón de Volver Atrás -->
    <div class="container mt-4">
        <div class="mb-4">
            <button class="btn btn-secondary" onclick="window.location.href='../escoger_opcion.php';">Volver Atrás</button>
        </div>

        <!-- Contenido principal -->
        <h1 class="text-center mb-4">Escoge una opción</h1>
        <div class="row">
            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="card">
                    <img src="../img/privado_este.jpg" class="card-img-top" alt="Privado Este">
                    <div class="card-body">
                        <h5 class="card-title">Privado Este</h5>
                        <a href="privado_este.php" class="btn btn-primary">Acceder</a>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="col-md-4">
                <div class="card">
                    <img src="../img/privado_oeste.jpg" class="card-img-top" alt="Privado Oeste">
                    <div class="card-body">
                        <h5 class="card-title">Privado Oeste</h5>
                        <a href="privado_oeste.php" class="btn btn-primary">Acceder</a>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="col-md-4">
                <div class="card">
                    <img src="../img/privado_sud.jpg" class="card-img-top" alt="Privado Sud">
                    <div class="card-body">
                        <h5 class="card-title">Privado Sud</h5>
                        <a href="privado_sud.php" class="btn btn-primary">Acceder</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de bienvenida con SweetAlert -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '¡Bienvenido!',
                text: 'Hola <?php echo $nombreUsuario; ?>, escoge una opcion.',
                icon: 'success',
                confirmButtonText: 'Gracias'
            });
        });
    </script>

    <!-- Bootstrap JS, Popper.js y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
