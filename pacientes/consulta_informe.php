<?php
  include('../conexion.php');

    try {
        // Obtener las fechas del formulario
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];

        // Consulta para obtener las citas médicas en el rango de fechas
        $stmt = $conn->prepare("
        SELECT cita_medica.fecha, cita_medica.hora, 
               personas_paciente.nombre AS nombre_paciente, personas_paciente.apellido AS apellido_paciente,
               personas_medico.nombre AS nombre_medico, personas_medico.apellido AS apellido_medico
        FROM cita_medica
        LEFT JOIN pacientes ON cita_medica.id_paciente = pacientes.id_paciente
        LEFT JOIN personas AS personas_paciente ON pacientes.id_persona = personas_paciente.id_persona
        LEFT JOIN medicos ON cita_medica.id_medico = medicos.id_medico
        LEFT JOIN empleados ON medicos.empleado_id = empleados.empleado_id
        LEFT JOIN personas AS personas_medico ON empleados.id_persona = personas_medico.id_persona
        ");
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

       
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    } 

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar el informe de las citas medicas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
   <div class='container'>
         <h2 class='mt-4 text-center'>Informe de Citas Médicas desde <?php echo $fecha_inicio . " hasta " . $fecha_fin ?></h2>
         <div class='mb-5 mt-3'>
         <form action="./generar_pdf.php" method="post">
            <input type="hidden" name="inicio" value="$fecha_inicio">
            <input type="hidden" name="fin" value="$fecha_fin">
            <button class="btn btn-primary">Generar PDF</button>
         </form>
         </div>

         <table class='table table-striped table-hover'>
          <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Médico</th>
            </tr>
           </thead>
          <tbody>
            <?php
               foreach ($resultados as $clave => $valor) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($valor['fecha']) . "</td>";
                echo "<td>" . htmlspecialchars($valor['hora']) . "</td>";
                echo "<td>" . htmlspecialchars($valor['nombre_paciente']) . " " . htmlspecialchars($valor['apellido_paciente']) . "</td>";
                echo "<td>" . htmlspecialchars($valor['nombre_medico']) . " " . htmlspecialchars($valor['apellido_medico']) . "</td>";
                echo "</tr>"; 
            } 
            ?>
          </tbody>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
