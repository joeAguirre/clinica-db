<?php
    session_start();
   // include_once('../sesiones/verificar_acesso.php');
   include_once('../../conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciente_id = $_POST['paciente_id'];
    $medico_id = $_POST['medico_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

     

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
            $_SESSION['mensaje'] = 'Cita médica reservada con éxito.';
            $_SESSION['tipo_mensaje'] = 'success';

            header("Location: ./ver_citas.php?id_paciente=" . $paciente_id);
            exit();
            
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
    header("Location: ../buscar_pacientes.php");
    exit();
}
?>


