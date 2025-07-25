<?php
session_start();
require_once '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_paciente = $_POST['id_paciente'];
    $fecha_ingreso = $_POST['fecha_ingreso'] ?? null;
    $motivo = htmlspecialchars(strip_tags(trim($_POST['motivo'])));
    $fecha_egreso = !empty($_POST['fecha_egreso']) ? $_POST['fecha_egreso'] : null;


    if ($id_paciente && $fecha_ingreso && $motivo) {
        try {
            $sql = "INSERT INTO internacion (id_paciente, fecha_ingreso, fecha_egreso, motivo)
                VALUES (:id_paciente, :fecha_ingreso, :fecha_egreso, :motivo)";
             $stmt = $conn->prepare($sql);
             $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
             $stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
             $stmt->bindParam(':fecha_egreso', $fecha_egreso);
             $stmt->bindParam(':motivo', $motivo);

             $stmt->execute();

            $_SESSION['mensaje'] = "Internación registrada correctamente.";
            $_SESSION['tipo_mensaje'] = "success";
            //echo "<div class='alert alert-success'>Internación registrada correctamente.</div>";
        } catch (PDOException $e) {
            $_SESSION['mensaje'] = "No se pudo registrar la internacion. " . $e->getMessage();
            $_SESSION['tipo_mensaje'] = "danger";
           // echo "<div class='alert alert-danger'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }

         header("Location: cargar_internacion.php");
         exit;
    } else {
        echo "<div class='alert alert-warning'>Por favor complete todos los campos.</div>";
    }
}
?>
