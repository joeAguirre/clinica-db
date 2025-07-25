<?php
session_start();
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_internacion = $_POST['id_internacion'];
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

        header("Location: ver_internacion.php?id_paciente=" . $id_internacion);
        exit;

    } catch (PDOException $e) {
        die("Error al actualizar: " . $e->getMessage());
    }
}
