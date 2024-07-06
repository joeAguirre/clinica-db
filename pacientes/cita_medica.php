<?php
  include('../conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciente_id = $_POST['paciente_id'];
} else {

    header("Location: buscar_paciente.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Cita Médica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-primary">Reservar Cita Médica</h2>
        <form action="procesar_reserva.php" method="post">
            <input type="hidden" name="paciente_id" value="<?php echo htmlspecialchars($paciente_id); ?>">
            <div class="mb-3">
                <label for="medico_id" class="form-label">Médico</label>
                <select class="form-select" id="medico_id" name="medico_id" required>
                    <option value="">Seleccione un médico</option>
                    <?php

                    
                    $stmt = $conn->prepare("
                        SELECT medicos.id_medico, personas.nombre, personas.apellido
                        FROM medicos
                        JOIN empleados ON medicos.empleado_id = empleados.empleado_id
                        JOIN personas ON empleados.id_persona = personas.id_persona
                    ");
                    $stmt->execute();
                    while ($medico = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='" . htmlspecialchars($medico['id_medico']) . "'>" . htmlspecialchars($medico['nombre']) . " " . htmlspecialchars($medico['apellido']) . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" required>
            </div>
            <button type="submit" class="btn btn-primary">Reservar</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>