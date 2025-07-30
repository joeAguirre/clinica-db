<?php
include_once('../../sesiones/verificar_acesso.php');
require_once '../../conexion.php';
require_once('../../plantilla/header.php');

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
                                ac.id_analisis,
                                ac.id_paciente,
                                per.nombre,
                                per.apellido,
                                ac.tipo,
                                ac.descripcion,
                                ac.resultado,
                                ac.fecha
                            FROM analisis_clinico ac
                            INNER JOIN pacientes pa ON ac.id_paciente = pa.id_paciente
                            INNER JOIN personas per ON pa.id_persona = per.id_persona
                            WHERE ac.id_paciente = :id_paciente
                            ORDER BY ac.fecha DESC");
    $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
    $stmt->execute();
    $analisis = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener análisis clínicos: " . $e->getMessage());
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

     <div class="">
         <a class="btn btn-danger" href="../buscar_pacientes.php">Volver</a>
         <h2 class="mb-4 text-center">Análisis Clínicos del Paciente</h2>
         <div class="d-flex justify-content-end">
            <!-- Denegar acceso a paciente -->
             <?php if ($_SESSION['rol'] !== 'paciente'):  ?>
                <a class="btn btn-success" href="./crear_analisis.php?id_paciente=<?php echo $id_paciente; ?>">Agregar Analisis</a>
              <?php endif; ?>
            </div>
         
    </div>

    <?php if (count($analisis) > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4">
            <?php foreach ($analisis as $a): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Tipo: <?php echo htmlspecialchars($a['tipo']); ?></h5>
                            <h6 class="card-subtitle mb-2 mt-2 text-muted">
                                Paciente: <?php echo htmlspecialchars($a['nombre'] . ' ' . $a['apellido']); ?>
                            </h6>
                            <p class="card-text"><strong>Descripción:</strong><br>
                                <?php echo nl2br(htmlspecialchars($a['descripcion'])); ?>
                            </p>
                            <p class="card-text"><strong>Resultado:</strong><br>
                                <?php echo nl2br(htmlspecialchars($a['resultado'])); ?>
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <small class="text-muted">Fecha: <?php echo $a['fecha']; ?></small>
                            <!-- Denegar acceso a paciente -->
                            <?php if ($_SESSION['rol'] !== 'paciente'):  ?>
                            <div>
                                <a href="editar_analisis.php?id=<?php echo $a['id_analisis']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="eliminar_analisis.php?id_analisis=<?php echo $a['id_analisis']; ?>" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este análisis?');">
                                    Eliminar
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning mt-4">Este paciente no tiene análisis clínicos registrados.</div>
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

<?php require_once('../../plantilla/footer.php'); ?>





