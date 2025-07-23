<?php
   session_start();
   include_once('../conexion.php');

   include_once('../sesiones/verificar_acesso.php');

   include('../plantilla/header.php');
?>



<?php
// Obtener el empleado_id 
     $empleado_id = isset($_GET['empleado_id']) ? intval($_GET['empleado_id']) : null;

    // Verificar si existe cronograma 
try {
    $stmt = $conn->prepare("SELECT * FROM cronograma_empleado WHERE id_empleado = ?");
    $stmt->execute([$empleado_id]);
    $cronogramaExistente = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    $horarios = [];
    foreach ($cronogramaExistente as $item) {
        $horarios[$item['id_dia']] = [
            'entrada' => $item['hora_entrada'],
            'salida' => $item['hora_salida']
        ];
    }

} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error al obtener el cronograma existente: " . $e->getMessage() . "</div>";
    exit;
}


    if (!$empleado_id) {
        echo "<div class='alert alert-danger'>No se proporcionó el empleado.</div>";
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT id_dia, nombre FROM dias_semana ORDER BY id_dia");
        $stmt->execute();
        $dias = $stmt->fetchAll(PDO::FETCH_ASSOC);

       
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error al obtener los días: " . $e->getMessage() . "</div>";
        exit;
    } 
?>



<form method="POST" action="guardar_cronograma.php">
    <h2 class="text-center py-3">Crear Cronograma</h2>
    <input type="hidden" name="id_empleado" value="<?= $empleado_id ?>">

  <?php foreach ($dias as $dia): ?>
        <div class="mb-3">
             
            <label class="form-label"><?= htmlspecialchars($dia['nombre']) ?></label>
            <div class="row">
                <div class="col">
                    <input 
                    type="time" name="horario[<?= $dia['id_dia'] ?>][entrada]" 
                    class="form-control"
                    value="<?= isset($horarios[$dia['id_dia']]['entrada']) ? $horarios[$dia['id_dia']]['entrada'] : '' ?>"
                     required >
                </div>
                <div class="col">
                    <input type="time" name="horario[<?= $dia['id_dia'] ?>][salida]" 
                    class="form-control" 
                    value="<?= isset($horarios[$dia['id_dia']]['salida']) ? $horarios[$dia['id_dia']]['salida'] : '' ?>"
                    required >
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <button type="submit" class="btn btn-primary">Guardar cronograma</button>
</form>
<br>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <div id="mensaje-anuncio"  class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
            ?>
        </div>
    <?php endif; ?>
    

     <script>

        setTimeout(function() {
            const mensaje = document.getElementById('mensaje-anuncio');
            if (mensaje) {
                mensaje.style.display = 'none';
            }
        },  3000); 
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
