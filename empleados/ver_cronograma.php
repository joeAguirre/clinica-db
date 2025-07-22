<?php
   session_start();
   include_once('../conexion.php');
   include_once('../sesiones/verificar_acesso.php');
   
   include_once('../plantilla/header.php');

   include('../conexion.php');

   
    $id_empleado = isset($_GET['empleado_id']) ? intval($_GET['empleado_id']) : 0;

    try {
        $sql = "SELECT ce.id_dia, ds.nombre AS dia, ce.hora_entrada, ce.hora_salida
            FROM cronograma_empleado ce
            JOIN dias_semana ds ON ce.id_dia = ds.id_dia
            WHERE ce.id_empleado = :id_empleado
            ORDER BY ce.id_dia";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_empleado' => $id_empleado]);
        $cronograma = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $e) {
        echo "<div class='alert alert-danger'>Error al obtener el cronograma: " . $e->getMessage() . "</div>";
        exit;
    }
    


?>

<div>
    <h3>Cronograma del Empleado</h3>
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div id="mensaje-anuncio"  class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
            ?>
        </div>
    <?php endif; ?>
    <div>
         <a class="btn btn-success mb-3" href="administrar_cronograma.php?empleado_id=<?= $id_empleado ?>" >
            Administrar Cronograma
        </a>
         <a href="./buscar_empleados.php" class="btn btn-secondary mb-3">Volver</a>

    </div>
    

    <?php if (count($cronograma) > 0): ?>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Día</th>
                    <th>Hora de Entrada</th>
                    <th>Hora de Salida</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cronograma as $fila): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['dia']) ?></td>
                        <td><?= htmlspecialchars($fila['hora_entrada']) ?> hs</td>
                        <td><?= htmlspecialchars($fila['hora_salida']) ?> hs</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">No hay cronograma cargado para este empleado.</div>
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
    include_once('../plantilla/footer.php');
?>