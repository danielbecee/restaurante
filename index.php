<?php
// Inicia la sesión
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Restaurante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<section class="vh-100" style="background-color: #548c94;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <!-- Imagen -->
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="./img/login.jpg" style="width: 100%; height: 100%; object-fit: cover;" />
            </div>

            <!-- Formulario -->
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">
                <form action="login.php" method="post">
                  <div class="d-flex align-items-center mb-3 pb-1">
                    <span class="h1 fw-bold mb-0">
                      <img src="./img/logo.png" alt="Logo" style="max-width: 150px;" />
                    </span>
                  </div>
                  <h5 class="fw-normal mb-3 pb-3">Inicia sesión</h5>

                  <!-- Usuario -->
                  <div class="form-outline mb-4">
                    <label class="form-label" for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control form-control-lg"  />
                  </div>

                  <!-- Contraseña -->
                  <div class="form-outline mb-4">
                    <label class="form-label" for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control form-control-lg"  />
                  </div>

                  <!-- Botón -->
                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
<?php
// Verifica si hay un mensaje de error en las variables de sesión y muestra una alerta
if (!empty($_SESSION['error_password'])) {
    echo "Swal.fire({
        title: 'Error',
        text: '" . $_SESSION['error_password'] . "',
        icon: 'error',
        confirmButtonText: 'Intentar de nuevo'
    });";
    // Limpia la variable de error para evitar que la alerta se muestre nuevamente
    unset($_SESSION['error_password']);
}
?>
</script>
</body>
</html>
