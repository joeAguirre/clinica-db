<?php
session_start();
// cargar_internacion.php
require_once '../conexion.php';

$sql = "SELECT p.id_paciente, per.nombre, per.apellido
        FROM pacientes p
        INNER JOIN personas per ON p.id_persona = per.id_persona";
$stmt = $conn->query($sql);
$pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cargar Internación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
     <?php if (isset($_SESSION['mensaje'])): ?>
        <div id="mensaje-anuncio"  class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
            ?>
        </div>
    <?php endif; ?>
    <h2 class="mb-4">Registrar Internación</h2>
    <form action="guardar_internacion.php" method="POST" class="card p-4 shadow rounded">
        <div class="mb-3">
            <label for="id_paciente" class="form-label">Paciente</label>
            <select name="id_paciente" class="form-select" required>
                <option value="">Seleccionar...</option>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?= $paciente['id_paciente'] ?>">
                        <?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha_ingreso" class="form-label">Fecha de ingreso</label>
            <input type="date" name="fecha_ingreso" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="fecha_egreso" class="form-label">Fecha de egreso (opcional)</label>
            <input type="date" class="form-control" name="fecha_egreso" id="fecha_egreso">
        </div>

        <div class="mb-3">
            <label for="motivo" class="form-label">Motivo</label>
            <input type="text" name="motivo" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar internación</button>
    </form>

</div>

</body>
</html>
