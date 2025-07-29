<?php
include_once('../../sesiones/verificar_acesso.php');
require_once '../../conexion.php';

require_once('../../plantilla/header.php');

if (isset($_GET['id_paciente']) && is_numeric($_GET['id_paciente'])) {
    $id_paciente = (int) $_GET['id_paciente'];
}

// Obtener lista de pacientes para el select
try {
    $stmt = $conn->query("SELECT p.id_paciente, per.nombre, per.apellido
                          FROM pacientes p
                          INNER JOIN personas per ON p.id_persona = per.id_persona
                          ORDER BY per.apellido, per.nombre");
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener pacientes: " . $e->getMessage());
}
?>



<div class="container mt-5">
    <h2>Nuevo Análisis Clínico</h2>
    <form action="guardar_analisis.php" method="POST">
        <div class="mb-3">
            <label for="id_paciente" class="form-label">Paciente</label>
            <select name="id_paciente" id="id_paciente" class="form-select" required>
                <option value="">Seleccionar paciente</option>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?= $paciente['id_paciente'] ?>" <?= ($id_paciente == $paciente['id_paciente']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            </select>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de análisis</label>
            <input type="text" name="tipo" id="tipo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="resultado" class="form-label">Resultado</label>
            <textarea name="resultado" id="resultado" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar análisis</button>
    </form>
</div>

<?php
    require_once('../../plantilla/footer.php');

?>
