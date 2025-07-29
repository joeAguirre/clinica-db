<?php
include_once('../../sesiones/verificar_acesso.php');

require_once '../../conexion.php';
require_once('../../plantilla/header.php');

// Validar el ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de cita no válido.");
}

$id = (int) $_GET['id'];

// Obtener la cita médica
try {
    $stmt = $conn->prepare("SELECT * FROM cita_medica WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $cita = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cita) {
        die("Cita médica no encontrada.");
    }

    // obtenr medicos
    $stmtMed = $conn->query("SELECT me.id_medico, per.nombre, per.apellido
    FROM medicos me
    INNER JOIN empleados e ON me.empleado_id = e.empleado_id
    INNER JOIN personas per ON e.id_persona = per.id_persona");
    $medicos = $stmtMed->fetchAll(PDO::FETCH_ASSOC);


} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!-- HTML + Bootstrap 5 -->
<div class="container mt-5">
    <h3>Editar Cita Médica</h3>
    <form action="actualizar_cita.php" method="POST">
        <input type="hidden" name="id_cita" value="<?php echo $cita['id']; ?>">
        <input type="hidden" name="id_paciente" value="<?php echo $cita['id_paciente']; ?>">

        <div class="mb-3">
            <label for="id_medico" class="form-label">Médico</label>
            
            <select name="id_medico" class="form-control" required>
                <?php foreach ($medicos as $medico): ?>
                    <option value="<?= $medico['id_medico']; ?>" 
                        <?= $medico['id_medico'] == $cita['id_medico'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($medico['nombre'] . ' ' . $medico['apellido']); ?>
                    </option>
               <?php endforeach; ?>
        
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="<?php echo $cita['fecha']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="hora" class="form-label">Hora</label>
            <input type="time" name="hora" class="form-control" value="<?php echo $cita['hora']; ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <a href="ver_citas.php?id_paciente=<?php echo $cita['id_paciente']; ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php require_once('../../plantilla/footer.php'); ?>
