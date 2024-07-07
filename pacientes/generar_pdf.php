<?php

ob_start();

include('../conexion.php');

try {
    // Obtener las fechas del formulario
    $fecha_inicio = $_POST['inicio'];
    $fecha_fin = $_POST['fin'];

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

    // Generar el HTML para el informe
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mostrar el informe de las citas médicas</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
            .table {
                width: 100%;
                margin-bottom: 1rem;
                color: #212529;
            }
            .table th,
            .table td {
                padding: 0.75rem;
                vertical-align: top;
                border-top: 1px solid #dee2e6;
            }
            .table thead th {
                vertical-align: bottom;
                border-bottom: 2px solid #dee2e6;
            }
            .table tbody + tbody {
                border-top: 2px solid #dee2e6;
            }
            /* .table-striped tbody tr:nth-of-type(odd) {
                 background-color: rgba(0, 0, 0, 0.05); 
            } */
            .table-hover tbody tr:hover {
                background-color: rgba(0, 0, 0, 0.075);
            }
            h2 {
                font-size: 2rem;
                text-align: center;
                margin-top: 1rem;
                margin-bottom: 1rem;
            }
        </style>
    </head>
    <body>
       <div>
             <h2 class='mt-4 text-center'>Informe de Citas Médicas</h2>

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
           </table>
       </div>

       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
    </html>
    <?php

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
} 

$conn = null;

$html = ob_get_clean();

require_once "../dompdf/autoload.inc.php";

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array("isRemoteEnabled" => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('letter');
//$dompdf->setPaper('A4', 'landscape');

$dompdf->render();

$dompdf->stream("archivo_.pdf", array("Attachment" => false));

?>
