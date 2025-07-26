<?php
require_once '../../conexion.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de internación no válido.");
}

$id = $_GET['id'];

try {
    $stmt = $conn->prepare("
        SELECT * FROM internacion 
        WHERE id_internacion = :id
    ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $internacion = $stmt->fetch(PDO::FETCH_ASSOC);

    print_r($internacion);
    if (!$internacion) {
        die("Internación no encontrada.");
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!-- HTML + Bootstrap 5 -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Internación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h3>Editar Internación</h3>
    <form action="actualizar_internacion.php" method="POST">
        <input type="hidden" name="id_internacion" value="<?php echo $internacion['id_internacion']; ?>">
        <input type="hidden" name="id_paciente" value="<?php echo $internacion['id_paciente']; ?>">


        <div class="mb-3">
            <label for="fecha_ingreso" class="form-label">Fecha Ingreso</label>
            <input type="date" name="fecha_ingreso" class="form-control" 
                   value="<?php echo htmlspecialchars($internacion['fecha_ingreso']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="fecha_egreso" class="form-label">Fecha Egreso</label>
            <input type="date" name="fecha_egreso" class="form-control" 
                   value="<?php echo htmlspecialchars($internacion['fecha_egreso']); ?>">
        </div>

        <div class="mb-3">
            <label for="motivo" class="form-label">Motivo</label>
            <textarea name="motivo" class="form-control" required><?php echo htmlspecialchars($internacion['motivo']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <a href="ver_internaciones.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
