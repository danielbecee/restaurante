<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_camarero'])) {
    header('Location: ../login.php'); // ajustar la ruta según sea necesario
    exit;
}
$id_camarero = $_SESSION['id_camarero'];

// Incluir la conexión a la base de datos
include_once('../conexion.php'); // ajustar la ruta según sea necesario

// Procesar el formulario de actualización del estado de la mesa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mesa_id']) && isset($_POST['estado'])) {
        // Obtener los valores del formulario
        $mesa_id = intval($_POST['mesa_id']);
        $estado = $_POST['estado'];

        // Validar el estado recibido
        if ($estado === 'libre' || $estado === 'ocupada') {
            // Obtener el estado actual antes de actualizarlo
            $sqlEstadoActual = "SELECT estado FROM Mesa WHERE ID_mesa = ?";
            $stmtEstado = mysqli_prepare($con, $sqlEstadoActual);
            mysqli_stmt_bind_param($stmtEstado, 'i', $mesa_id);
            mysqli_stmt_execute($stmtEstado);
            $resultEstado = mysqli_stmt_get_result($stmtEstado);
            $rowEstado = mysqli_fetch_assoc($resultEstado);

            if ($rowEstado) {
                $estado_anterior = $rowEstado['estado'];

                // Iniciar una transacción
                mysqli_begin_transaction($con);

                // Validar la transición de estado
                if (!(($estado_anterior === 'libre' && $estado === 'ocupada') || 
                      ($estado_anterior === 'ocupada' && $estado === 'libre'))) {
                    echo "Error: Transición de estado inválida.";
                    mysqli_rollback($con);
                    exit;
                }

                // Actualizar el estado de la mesa
                $sqlUpdateMesa = "UPDATE Mesa SET estado = ? WHERE ID_mesa = ?";
                $stmtUpdateMesa = mysqli_prepare($con, $sqlUpdateMesa);
                mysqli_stmt_bind_param($stmtUpdateMesa, 'si', $estado, $mesa_id);
                if (!mysqli_stmt_execute($stmtUpdateMesa)) {
                    echo "Error al actualizar el estado de la mesa.";
                    mysqli_rollback($con);
                    exit;
                }

                if ($estado_anterior === 'libre' && $estado === 'ocupada') {
                    // Insertar el cambio en la tabla Ocupacion
                    $sqlInsertOcupacion = "
                        INSERT INTO Ocupacion (ID_mesa, ID_camarero, fecha_hora_inicio, estado_anterior, estado_actual)
                        VALUES (?, ?, NOW(), ?, ?)
                    ";
                    $stmtInsertOcupacion = mysqli_prepare($con, $sqlInsertOcupacion);
                    $id_camarero = $_SESSION['id_camarero'] ?? 1; // Obtener el ID del camarero actual
                    mysqli_stmt_bind_param($stmtInsertOcupacion, 'iiss', $mesa_id, $id_camarero, $estado_anterior, $estado);
                    if (!mysqli_stmt_execute($stmtInsertOcupacion)) {
                        echo "Error al insertar en Ocupacion.";
                        mysqli_rollback($con);
                        exit;
                    }
                }

                if ($estado_anterior === 'ocupada' && $estado === 'libre') {
                    // Actualizar fecha_hora_final para la ocupación activa
                    $sqlUpdateFechaFinal = "
                        UPDATE Ocupacion
                        SET fecha_hora_final = NOW()
                        WHERE ID_mesa = ? AND fecha_hora_final IS NULL
                    ";
                    $stmtUpdateFechaFinal = mysqli_prepare($con, $sqlUpdateFechaFinal);
                    mysqli_stmt_bind_param($stmtUpdateFechaFinal, 'i', $mesa_id);
                    if (!mysqli_stmt_execute($stmtUpdateFechaFinal)) {
                        echo "Error al actualizar fecha_hora_final en Ocupacion.";
                        mysqli_rollback($con);
                        exit;
                    }
                    mysqli_stmt_close($stmtUpdateFechaFinal);
                }

                // Confirmar la transacción
                mysqli_commit($con);

                // Redirigir para ver los cambios con un parámetro de éxito
                header("Location: comedor_este.php?status=success");
                exit;
            } else {
                echo "Error: Mesa no encontrada.";
                mysqli_close($con);
                exit;
            }
        } else {
            echo "Error: Estado no válido.";
        }
    } else {
        echo "Error: No se han recibido los parámetros necesarios.";
    }
}

// Código para mostrar las mesas
try {
    // Consulta para obtener las mesas del comedor
    $sql = "
        SELECT m.ID_mesa, m.capacidad, m.estado, s.nombre_sala
        FROM Mesa m
        JOIN Sala s ON m.ID_sala = s.ID_sala
        WHERE s.tipo_sala = 'Comedor Este'
    ";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de las Mesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="background-color: #548c94;">
<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <script>
        Swal.fire({
            title: '¡Cambio realizado!',
            text: 'El estado de la mesa se actualizó correctamente.',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    </script>
<?php endif; ?>
<header class="bg-light py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <span class="font-weight-bold">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
        <a href="../historial.php" class="btn btn-secondary btn-sm">Historial</a>
        <form action="../logout.php" method="POST">
            <button type="submit" class="btn btn-danger btn-sm">Cerrar sesión</button>
        </form>
    </div>
</header>
<a href="./tipo_sala_comedor.php" class="btn btn-secondary btn-sm">Volver</a>
<div class="container mt-4">
    <h1 class="text-center mb-4">Estado de las Mesas</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <?php $imagen_estado = ($row['estado'] === 'libre') ? 'mesa_verde_s.png' : 'mesa_roja_s.png'; ?>
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <img src="../img/<?php echo $imagen_estado; ?>" alt="Estado de la mesa" class="img-fluid mesa-img mb-3">
                        <h5 class="card-title">Mesa: <?php echo htmlspecialchars($row['ID_mesa']); ?></h5>
                        <p class="card-text">Sala: <?php echo htmlspecialchars($row['nombre_sala']); ?></p>
                        <p class="card-text">Capacidad: <?php echo htmlspecialchars($row['capacidad']); ?> personas</p>
                        <p class="card-text">Estado: <?php echo ($row['estado'] === 'libre') ? 'Disponible' : 'Ocupada'; ?></p>
                        <form action="comedor_este.php" method="POST">
                            <input type="hidden" name="mesa_id" value="<?php echo htmlspecialchars($row['ID_mesa']); ?>">
                            <div class="form-group">
                                <label for="estado">Estado:</label>
                                <select name="estado" class="form-select">
                                    <option value="libre"<?php echo ($row['estado'] === 'libre') ? ' selected' : ''; ?>>Libre</option>
                                    <option value="ocupada"<?php echo ($row['estado'] === 'ocupada') ? ' selected' : ''; ?>>Ocupada</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar estado</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
<?php
    mysqli_free_result($result);
    mysqli_close($con);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
