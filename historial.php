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
include_once('./conexion.php'); // ajustar la ruta según sea necesario

// Inicializar los filtros
$mesa_id_filter = isset($_GET['mesa_id']) ? $_GET['mesa_id'] : '';
$camarero_filter = isset($_GET['nombre_camarero']) ? $_GET['nombre_camarero'] : '';
$id_ocupacion_filter = isset($_GET['id_ocupacion']) ? $_GET['id_ocupacion'] : '';
$fecha_inicio_filter = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : '';
$fecha_fin_filter = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : '';
$sala_filter = isset($_GET['nombre_sala']) ? $_GET['nombre_sala'] : '';

// Crear la consulta SQL dinámica con los filtros
$sql = "
    SELECT 
        o.ID_ocupacion, 
        o.ID_mesa, 
        o.fecha_hora_inicio, 
        o.fecha_hora_final, 
        c.nombre AS nombre_camarero, 
        o.estado_anterior, 
        o.estado_actual, 
        s.nombre_sala
    FROM Ocupacion o
    JOIN Mesa m ON o.ID_mesa = m.ID_mesa
    JOIN Camarero c ON o.ID_camarero = c.ID_camarero
    JOIN Sala s ON m.ID_sala = s.ID_sala
    WHERE 1 = 1
";

if (!empty($mesa_id_filter)) {
    $sql .= " AND o.ID_mesa = " . intval($mesa_id_filter);
}
if (!empty($camarero_filter)) {
    $sql .= " AND c.nombre LIKE '%" . mysqli_real_escape_string($con, $camarero_filter) . "%'";
}
if (!empty($id_ocupacion_filter)) {
    $sql .= " AND o.ID_ocupacion = " . intval($id_ocupacion_filter);
}
if (!empty($fecha_inicio_filter)) {
    $sql .= " AND o.fecha_hora_inicio >= '" . mysqli_real_escape_string($con, $fecha_inicio_filter) . "'";
}
if (!empty($fecha_fin_filter)) {
    $sql .= " AND o.fecha_hora_final <= '" . mysqli_real_escape_string($con, $fecha_fin_filter) . "'";
}
if (!empty($sala_filter)) {
    $sql .= " AND s.nombre_sala LIKE '%" . mysqli_real_escape_string($con, $sala_filter) . "%'";
}

$sql .= " ORDER BY o.fecha_hora_inicio DESC";

$result = mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Ocupaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #548c94;">
<header class="bg-light py-3 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
        <a href="./escoger_opcion.php" class="btn btn-secondary btn-sm">Volver</a>
        <form action="./logout.php" method="POST">
            <button type="submit" class="btn btn-danger btn-sm">Cerrar sesión</button>
        </form>
    </div>
</header>
<div class="container mt-4">
    <h1 class="text-center mb-4">Historial de Ocupaciones</h1>

    <!-- Formulario de Filtros -->
    <form action="historial.php" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-2 mb-3">
                <label for="mesa_id" class="form-label">Mesa ID</label>
                <input type="text" name="mesa_id" id="mesa_id" class="form-control" value="<?php echo htmlspecialchars($mesa_id_filter); ?>">
            </div>
            <div class="col-md-2 mb-3">
                <label for="nombre_camarero" class="form-label">Camarero</label>
                <input type="text" name="nombre_camarero" id="nombre_camarero" class="form-control" value="<?php echo htmlspecialchars($camarero_filter); ?>">
            </div>
            <div class="col-md-2 mb-3">
                <label for="id_ocupacion" class="form-label">ID Ocupación</label>
                <input type="text" name="id_ocupacion" id="id_ocupacion" class="form-control" value="<?php echo htmlspecialchars($id_ocupacion_filter); ?>">
            </div>
            <div class="col-md-2 mb-3">
                <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="<?php echo htmlspecialchars($fecha_inicio_filter); ?>">
            </div>
            <div class="col-md-2 mb-3">
                <label for="fecha_fin" class="form-label">Fecha Fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="<?php echo htmlspecialchars($fecha_fin_filter); ?>">
            </div>
            <div class="col-md-2 mb-3">
                <label for="nombre_sala" class="form-label">Nombre Sala</label>
                <input type="text" name="nombre_sala" id="nombre_sala" class="form-control" value="<?php echo htmlspecialchars($sala_filter); ?>">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Tabla de Resultados -->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID Ocupación</th>
                <th>Mesa ID</th>
                <th>Fecha Inicio</th>
                <th>Fecha Final</th>
                <th>Camarero</th>
                <th>Estado Anterior</th>
                <th>Estado Actual</th>
                <th>Nombre Sala</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID_ocupacion']); ?></td>
                    <td><?php echo htmlspecialchars($row['ID_mesa']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_hora_inicio']); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_hora_final']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_camarero']); ?></td>
                    <td><?php echo htmlspecialchars($row['estado_anterior']); ?></td>
                    <td><?php echo htmlspecialchars($row['estado_actual']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_sala']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
mysqli_free_result($result);
mysqli_close($con);
?>
