<?php

require_once '../../conexion.php';
include_once('../../sesiones/verificar_acesso.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_internacion = (int) $_POST['id_internacion'];
    $id_paciente = htmlspecialchars($_POST['id_paciente']);
    $fecha_ingreso = htmlspecialchars($_POST['fecha_ingreso']);
    $fecha_egreso = !empty($_POST['fecha_egreso']) ? htmlspecialchars($_POST['fecha_egreso']) : null;
    $motivo = htmlspecialchars($_POST['motivo']);

    try {
        $stmt = $conn->prepare("
            UPDATE internacion
            SET fecha_ingreso = :fecha_ingreso,
                fecha_egreso = :fecha_egreso,
                motivo = :motivo
            WHERE id_internacion = :id_internacion
        ");

        
        $stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
        $stmt->bindParam(':fecha_egreso', $fecha_egreso);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':id_internacion', $id_internacion);
        $stmt->execute();

        $_SESSION['mensaje'] = "registro actualizado correctamente.";
        $_SESSION['tipo_mensaje'] = "success";

        echo "<br>";
        echo $id_paciente;
        echo "<br>";
        echo $fecha_egreso;
        echo $motivo;
        header("Location: ver_internacion.php?id_paciente=" . $id_paciente);
        exit;

    } catch (PDOException $e) {
        die("Error al actualizar: " . $e->getMessage());
    }
} else {
    $_SESSION['mensaje'] = "No se proporcionaron datos de internacion";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: ../buscar_pacientes.php");
    exit;
}
