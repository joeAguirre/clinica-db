<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciente_id = $_POST['paciente_id'];
    $medico_id = $_POST['medico_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
     include('../conexion.php');
     try {

        $stmt = $conn->prepare("
            INSERT INTO cita_medica (id_paciente, id_medico, fecha, hora)
            VALUES (:id_paciente, :id_medico, :fecha, :hora)
        ");
        $stmt->bindParam(':id_paciente', $paciente_id, PDO::PARAM_INT);
        $stmt->bindParam(':id_medico', $medico_id, PDO::PARAM_INT);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<div class='container mt-5'>";
            echo "<div class='alert alert-success'>Cita médica reservada con éxito.</div>";
            echo "<a href='buscar_pacientes.php' class='btn btn-primary'>Volver a la búsqueda de pacientes</a>";
            echo "</div>";
        } else {
            echo "<div class='container mt-5'>";
            echo "<div class='alert alert-danger'>Error al reservar la cita médica.</div>";
            echo "<a href='reservar_cita.php' class='btn btn-primary'>Volver a intentar</a>";
            echo "</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='container mt-5'>";
        echo "<div class='alert alert-danger'>Error en la conexión: " . $e->getMessage() . "</div>";
        echo "<a href='reservar_cita.php' class='btn btn-primary'>Volver a intentar</a>";
        echo "</div>";
    }
} else {
    // Redireccionar si se intenta acceder directamente
    header("Location: buscar_pacientes.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procesar Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
