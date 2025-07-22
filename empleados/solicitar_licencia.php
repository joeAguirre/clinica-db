 <?php
 session_start();
 include_once('../sesiones/verificar_acesso.php');
include_once('../conexion.php');


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['empleado_id'])) {
        $empleado_id = intval($_POST['empleado_id']);
    } elseif (isset($_GET['empleado_id'])) {
        $empleado_id = intval($_GET['empleado_id']);
    } else {
        echo "Solicitud inválida.";
        exit;
    }
?> 
 
 <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Solicitar Licencia</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container mt-5">
        <h2>Solicitud de Licencia</h2>
        <form method="POST" action="./guardar_licencia.php">
            <input type="hidden" name="empleado_id" value="<?php echo $empleado_id; ?>">
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
                <input type="date" class="form-control" name="fecha_inicio" required>
            </div>
            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha de fin</label>
                <input type="date" class="form-control" name="fecha_fin" required>
            </div>
            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo</label>
                <textarea class="form-control" name="motivo" rows="3" placeholder="Opcional"></textarea>
            </div>
            <div class="mb-3">
                <label for="empleado_sustituto" class="form-label">Empleado sustituto</label>
                <select class="form-control" name="empleado_sustituto" required>
                <option value="">Seleccione un sustituto</option>
                <?php
                
                try {
                    $query = "SELECT empleados.empleado_id, personas.nombre, personas.apellido
                            FROM empleados
                            JOIN personas ON empleados.id_persona = personas.id_persona
                            WHERE empleados.empleado_id != :empleado_id";

                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':empleado_id', $empleado_id, PDO::PARAM_INT);
                    $stmt->execute();

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $row['id_empleado'] . '">' . htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) . '</option>';
                    } 
                } catch (PDOException $e) {
                    echo "<option disabled>Error al cargar empleados</option>";
                }
                ?>
                </select>
             </div>

             <div class="mb-3">
                 <button type="submit" class="btn btn-primary">Enviar solicitud</button>
                 <a href="./buscar_empleados.php" class="btn btn-secondary ms-2">Volver</a>
             </div>
            
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
    </div>


    <script>

        setTimeout(function() {
            const mensaje = document.getElementById('mensaje-anuncio');
            if (mensaje) {
                mensaje.style.display = 'none';
            }
        },  3000); 
    </script>
    </body>
    </html>

   
