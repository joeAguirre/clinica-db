<?php
     
     ini_set('display_errors', 1);
     ini_set('display_startup_errors', 1);
     error_reporting(E_ALL);

     include_once('../sesiones/verificar_acesso.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
   <style>
        .formulario-busqueda {
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container formulario-busqueda">
        <?php if (isset($_SESSION['mensaje'])): ?>
        <div id="mensaje-anuncio" class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
            ?>
        </div>
    <?php endif; ?>
        <h2 class="text-center">Buscar Médico</h2>
       
        <form method="post">
            <div class="mb-3">
                <label for="codigo_medico" class="form-label">Código Médico</label>
                <input type="text" class="form-control" id="codigo_medico" name="codigo_medico" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="../index.php?page=medicos" class="btn btn-secondary">Volver al Inicio</a>
            </div>
        </form>
    </div>

    <!--      script php      -->
<?php

     require '../conexion.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $sql = "SELECT personas.*, empleados.*, medicos.*, especialidades.nombre AS especialidad
            FROM personas
            JOIN empleados ON personas.id_persona = empleados.id_persona
            JOIN medicos ON empleados.empleado_id = medicos.empleado_id
            JOIN especialidades ON medicos.id_especialidad = especialidades.id_especialidad
            WHERE medicos.codigo_medico = :codigo_medico";
    
            $stmt = $conn->prepare($sql);
    
            $stmt->execute([':codigo_medico' => $_POST['codigo_medico']]);
    
            // Obtener los resultados
            $medicos = $stmt->fetchAll();

            // print_r($medicos);
    
    
            if (count($medicos) > 0) {
                echo '<div class="container">';
                echo '<h3 class="text-center">Resultados de la búsqueda</h3>';
                echo '<table class="table table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Nombre</th>';
                echo '<th>Apellido</th>';
                echo '<th>Especialidad</th>';
                echo '<th>Acciones</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($medicos as $medico) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($medico['nombre']) . '</td>';
                    echo '<td>' . htmlspecialchars($medico['apellido']) . '</td>';
                    echo '<td>' . htmlspecialchars($medico['especialidad']) . '</td>';
                    echo '<td>';
                   
                        echo '<a href="./editar_medico.php?id=' .$medico['empleado_id'] . '" class="btn btn-primary btn-sm text-white">';
                        echo "<i class='bi bi-pencil-square'></i>";
                        echo  '</a> ';
                        echo '<a href="./eliminar_medicos.php?id=' .$medico['empleado_id'] . '" class="btn btn-danger btn-sm text-white">';
                        echo '<i class="bi bi-trash"></i>';
                        echo  '</a> ';
                        
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            } else {

              echo "<h4 class='text-center'>No se encontro medico con el codigo especificado";

               
            } 
         } catch (PDOException $e) {
            echo '<div class="container">';
            echo '<p class="text-center text-danger">Error: ' . $e->getMessage() . '</p>';
            echo '</div>';
         }
    } 

    
        ?>


     <script>

        setTimeout(function() {
            const mensaje = document.getElementById('mensaje-anuncio');
            if (mensaje) {
                mensaje.style.display = 'none';
            }
        },  3000); 
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>



       