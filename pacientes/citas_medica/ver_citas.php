<?php
include_once('../../sesiones/verificar_acesso.php');
require_once '../../conexion.php';
require_once('../../plantilla/header.php');

// Verificar ID del paciente
if (isset($_POST['paciente_id']) && is_numeric($_POST['paciente_id'])) {
    $id_paciente = (int) $_POST['paciente_id'];
} elseif (isset($_GET['id_paciente']) && is_numeric($_GET['id_paciente'])) {
    $id_paciente = (int) $_GET['id_paciente'];
} else {
    echo '<div class="container mt-5"><div class="alert alert-danger">No se proporcionó un paciente válido.</div></div>';
    require_once('../../plantilla/footer.php');
    exit;
}

try {
    $stmt = $conn->prepare("SELECT 
                                cm.id,
                                cm.fecha,
                                cm.hora,
                                perpac.nombre AS nombre_paciente,
                                perpac.apellido AS apellido_paciente,
                                permed.nombre AS nombre_medico,
                                permed.apellido AS apellido_medico
                            FROM cita_medica cm
                            INNER JOIN pacientes pa ON cm.id_paciente = pa.id_paciente
                            INNER JOIN personas perpac ON pa.id_persona = perpac.id_persona

                            INNER JOIN medicos me ON cm.id_medico = me.id_medico
                            INNER JOIN empleados e ON me.empleado_id = e.empleado_id
                            INNER JOIN personas permed ON e.id_persona = permed.id_persona
                            WHERE cm.id_paciente = :id_paciente
                            ORDER BY cm.fecha DESC, cm.hora DESC");
    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
    $stmt->execute();
    $citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener citas médicas: " . $e->getMessage());
}
?>

<div class="container mt-5">
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div id="mensaje-anuncio" class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
            ?>
        </div>
    <?php endif; ?>

    <div>
        <a class="btn btn-danger" href="../buscar_pacientes.php">Volver</a>
        <h2 class="mb-4 text-center">Citas Médicas del Paciente</h2>
        <div class="d-flex justify-content-end">
            <a class="btn btn-success" href="./crear_cita.php?id_paciente=<?php echo $id_paciente; ?>">Agregar Cita</a>
        </div>
    </div>

    <?php if (count($citas) > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4">
            <?php foreach ($citas as $cita): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mt-2">Fecha: <?php echo $cita['fecha']; ?></h5>
                            <h5 class="card-title mt-2"> Hora: <?php echo $cita['hora']; ?></h5>
                            <p class="card-text">
                                <strong>Médico:</strong> 
                                <?php echo htmlspecialchars($cita['nombre_medico'] . ' ' . $cita['apellido_medico']); ?>
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <div>
                                <a href="editar_cita.php?id=<?php echo $cita['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="eliminar_cita.php?id=<?php echo $cita['id']; ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar esta cita?');">
                                    Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning mt-4">Este paciente no tiene citas médicas registradas.</div>
    <?php endif; ?>
</div>

<script>
    setTimeout(function() {
        const mensaje = document.getElementById('mensaje-anuncio');
        if (mensaje) {
            mensaje.style.display = 'none';
        }
    }, 3000);
</script>

<?php require_once('../../plantilla/footer.php'); ?>
