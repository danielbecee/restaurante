<?php
// Iniciar la sesión
session_start();

// Suponiendo que el nombre del usuario está guardado en $_SESSION['nombre']
if (!isset($_SESSION['id_camarero'])) {
    header('Location: ../login.php'); // ajustar la ruta según sea necesario
    exit;
}
$id_camarero = $_SESSION['id_camarero'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Opción</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./js/scripts.js"></script>
    <script>
        // Llamar a la función de bienvenida con el nombre del usuario
        mostrarBienvenida('<?php echo $_SESSION['nombre']; ?>');
    </script>
<body style="background-color: #548c94;">
<!-- Header -->
<header class="bg-light py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <span class="font-weight-bold">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
        <a href="./historial.php" class="btn btn-secondary btn-sm"><i class="fas fa-history">Historial</i></a>
        <form action="logout.php" method="POST">
            <button type="submit" class="btn btn-danger btn-sm">Cerrar sesión</button>
        </form>
    </div>
</header>
<!-- Contenido principal -->
<div class="container mt-4">
    <h1 class="text-center mb-4">Escoge una opción</h1>
    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card">
                <img src="./img/terraza.png" class="card-img-top" alt="Terraza">
                <div class="card-body">
                    <h5 class="card-title">Terraza</h5>
                    <a href="./tipo_sala/tipo_sala_terraza.php" class="btn btn-primary">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4">
            <div class="card">
                <img src="./img/privada.jpg" class="card-img-top" alt="Privado">
                <div class="card-body">
                    <h5 class="card-title">Privado</h5>
                    <a href="./tipo_sala/tipo_sala_privado.php" class="btn btn-primary">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4">
            <div class="card">
                <img src="./img/comedor.jpg" class="card-img-top" alt="Comedor">
                <div class="card-body">
                    <h5 class="card-title">Comedor</h5>
                    <a href="./tipo_sala/tipo_sala_comedor.php" class="btn btn-primary">Acceder</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
<?php
// Asegurarse de que el nombre de usuario esté presente
if (isset($_SESSION['nombre'])) {
    $nombreUsuario = htmlspecialchars($_SESSION['nombre']);
    echo "
    console.log('Bienvenido: $nombreUsuario'); // Verifica si se muestra el nombre correctamente en la consola
    Swal.fire({
        title: '¡Bienvenido!',
        text: 'Hola $nombreUsuario, esperamos que tengas un excelente día.',
        icon: 'success',
        confirmButtonText: 'Gracias'
    });
    ";
}
?>
</script>
<!-- Bootstrap JS, Popper.js y jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>