<?php

ob_start();

include('../conexion.php');

try {
    $especialidad = $_POST['especialidad'];

    // Consulta para obtener los médicos por especialidad
    $stmt = $conn->prepare("
    SELECT medicos.especialidad, 
           personas.nombre AS nombre_medico, 
           personas.apellido AS apellido_medico,
           personas.email,
           personas.fecha_nacimiento
    FROM medicos
    LEFT JOIN empleados ON medicos.empleado_id = empleados.empleado_id
    LEFT JOIN personas ON empleados.id_persona = personas.id_persona
    WHERE medicos.especialidad = :especialidad
    ORDER BY personas.apellido, personas.nombre
    ");
    $stmt->bindParam(':especialidad', $especialidad);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informe de Médicos por Especialidad</title>
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
            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(0, 0, 0, 0.05);
            }
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
             <h2>Informe de Médicos por Especialidad: <?php echo $especialidad; ?></h2>
             <table class='table table-striped table-hover'>
              <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Fecha de Nacimiento</th>
                </tr>
               </thead>
              <tbody>
                <?php
                foreach ($resultados as $clave => $valor) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($valor['nombre_medico']) . "</td>";
                    echo "<td>" . htmlspecialchars($valor['apellido_medico']) . "</td>";
                    echo "<td>" . htmlspecialchars($valor['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($valor['fecha_nacimiento']) . "</td>";
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

$dompdf->stream("informe_medicos_por_especialidad.pdf", array("Attachment" => false));

?>
