<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
        <h2 class="text-center">Buscar Médico</h2>
        <?php
        session_start();
        
        if (isset($_SESSION['mensaje_error'])) {
            echo '<div class="alert alert-danger text-center">' . htmlspecialchars($_SESSION['mensaje_error']) . '</div>';
            unset($_SESSION['mensaje_error']);
        }
        ?>
        <form method="post">
            <div class="mb-3">
                <label for="codigo_medico" class="form-label">Código Médico</label>
                <input type="text" class="form-control" id="codigo_medico" name="codigo_medico" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="../index.php" class="btn btn-secondary">Volver al Inicio</a>
            </div>
        </form>
    </div>

    <!--      script php      -->
<?php

     require '../conexion.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $sql = "SELECT personas.*, empleados.*, medicos.*
            FROM personas
            JOIN empleados ON personas.id_persona = empleados.id_persona
            JOIN medicos ON empleados.empleado_id = medicos.empleado_id
            WHERE medicos.codigo_medico = :codigo_medico";
    
            $stmt = $conn->prepare($sql);
    
            $stmt->execute([':codigo_medico' => $_POST['codigo_medico']]);
    
            // Obtener los resultados
            $medicos = $stmt->fetchAll();
    
    
            if (count($medicos) > 0) {
                echo '<div class="container">';
                echo '<h3 class="text-center">Resultados de la búsqueda</h3>';
                echo '<table class="table table-striped">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Nombre</th>';
                echo '<th>Apellido</th>';
                echo '<th>Especialidad</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                foreach ($medicos as $medico) {
                    echo '<tr>';
                    echo '<td><a href="detalle_medico.php?codigo_medico=' . htmlspecialchars($medico['codigo_medico']) . '">' . htmlspecialchars($medico['nombre']) . '</a></td>';
                    echo '<td>' . htmlspecialchars($medico['apellido']) . '</td>';
                    echo '<td>' . htmlspecialchars($medico['especialidad']) . '</td>';
                    echo '<td>';
                    echo '<a href="./disponibilidad_medicos.php' . '" class="btn btn-info btn-sm text-white">Configurar Disponibilidad</a> ';
                    echo '<a href="solicitar_licencia.php?codigo_medico=' . htmlspecialchars($medico['codigo_medico']) . '" class="btn btn-warning btn-sm">Solicitar Licencia</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            } else {
                $_SESSION['mensaje_error'] = 'No se encontró ningún médico con el código especificado.';
            } 
         } catch (PDOException $e) {
            echo '<div class="container">';
            echo '<p class="text-center text-danger">Error: ' . $e->getMessage() . '</p>';
            echo '</div>';
         }
    } 

    
        ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>



       