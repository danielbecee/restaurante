<?php
// Inicia una sesión nueva o reanuda una existente
session_start();

// Verifica si el método de solicitud es POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars(trim($_POST['usuario']));
    $password = htmlspecialchars(trim($_POST['password']));

    try {
        include "conexion.php";

        $sql = "SELECT * FROM camarero WHERE usuario = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($resultado) > 0) {
            $fila = mysqli_fetch_assoc($resultado);

            if (password_verify($password, $fila['contrasena'])) {
                // Guardar datos del usuario en la sesión
                $_SESSION['id_camarero'] = $fila['ID_camarero'];
                $_SESSION['nombre'] = $fila['nombre'];
                $_SESSION['username'] = $fila['usuario'];

                // Redirigir al menú principal
                header("Location: escoger_opcion.php");
                exit();
            } else {
                $_SESSION['error_password'] = "Contraseña incorrecta.";
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['error_password'] = "Usuario no encontrado.";
            header("Location: index.php");
            exit();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
