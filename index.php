<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Restaurante</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="script.js"></script>
</head>
<body>
<div class="container d-flex align-items-center justify-content-center vh-100">
    <div class="col-md-6 col-lg-4">
        <div class="card p-4 shadow">
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            <form action="login.php" method="post" >
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Introduce tu usuario" value="daniel" >
                    <p class="text-danger"><?php echo isset($_SESSION['error_username']) ? $_SESSION['error_username'] : ''; ?></p>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" >
                    <p class="text-danger"><?php echo isset($_SESSION['error_password']) ? $_SESSION['error_password'] : ''; ?></p>
                </div>
                <input type="submit" value="entrar" class="btn btn-primary btn-block"></input>
            </form>
            <div class="text-center mt-3">
                <a href="#">¿Has olvidado tu contraseña?</a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>