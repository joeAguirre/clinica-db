<?php
session_start();
require_once '../../conexion.php';

    if (isset($_POST['id_paciente']) && is_numeric($_POST['id_paciente'])) {
        $id_paciente = (int) $_POST['id_paciente'];
    } elseif (isset($_GET['id_paciente']) && is_numeric($_GET['id_paciente'])) {
        $id_paciente = (int) $_GET['id_paciente'];
    } else {
        echo '<div class="container mt-5"><div class="alert alert-danger">No se proporcionó un paciente válido.</div></div>';
        require_once('../../plantilla/footer.php');
        exit;
    }

try {
      $stmt = $conn->prepare("SELECT 
                                i.id_internacion,
                                i.id_paciente,
                                per.nombre,
                                per.apellido,
                                i.fecha_ingreso,
                                i.fecha_egreso,
                                i.motivo
                            FROM internacion i
                            INNER JOIN pacientes pa ON i.id_paciente = pa.id_paciente
                            INNER JOIN personas per ON pa.id_persona = per.id_persona
                            WHERE i.id_paciente = :id_paciente");
    
    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
    $stmt->execute();
    $internaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener internaciones: " . $e->getMessage());
}
?>

<?php
    include_once("../../plantilla/header.php");
  
?>
<body>
<div class="container mt-5">
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div id="mensaje-anuncio" class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
            ?>
        </div>
    <?php endif; ?>
    
    <div class="">
         <a class="btn btn-danger" href="../buscar_pacientes.php">Volver</a>
         <h2 class="mb-4 text-center">Listado de Internaciones</h2>
         <div class="d-flex justify-content-end">
            <a class="btn btn-success my-2" href="./cargar_internacion.php?id_paciente=<?php echo $id_paciente; ?>">Cargar Internacion</a>
        </div>
    </div>
    

    <?php if (count($internaciones) > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($internaciones as $fila): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-2">Internación #<?php echo $fila['id_internacion']; ?></h5>
                            <p class="card-text mb-1"><strong>Paciente:</strong> <?php echo htmlspecialchars($fila['nombre'] . ' ' . $fila['apellido']); ?></p>
                            <p class="card-text mb-1"><strong>ID Paciente:</strong> <?php echo $fila['id_paciente']; ?></p>
                            <p class="card-text mb-1"><strong>Fecha de Ingreso:</strong> <?php echo $fila['fecha_ingreso']; ?></p>
                            <p class="card-text mb-1"><strong>Fecha de Egreso:</strong> <?php echo $fila['fecha_egreso'] ?? '<span class="text-muted">—</span>'; ?></p>
                            <p class="card-text"><strong>Motivo:</strong> <?php echo htmlspecialchars($fila['motivo']); ?></p>
                        </div>
                        <div class="card-footer text-center">
                            <a href="editar_internacion.php?id=<?php echo $fila['id_internacion']; ?>" class="btn btn-primary btn-sm me-2">Editar</a>
                            <a href="eliminar_internacion.php?id=<?php echo $fila['id_internacion']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('¿Estás seguro de eliminar esta internación?');">
                               Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No hay internaciones registradas.</div>
    <?php endif; ?>
</div>


     <script>

        setTimeout(function() {
            const mensaje = document.getElementById('mensaje-anuncio');
            if (mensaje) {
                mensaje.style.display = 'none';
            }
        },  3000); 
    </script>

<?php
    include_once('../../plantilla/header.php');

?>

