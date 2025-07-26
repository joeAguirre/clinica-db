<?php
session_start();
require_once '../../conexion.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        //obtener paciente
        $stmt = $conn->prepare("SELECT id_paciente FROM internacion WHERE id_internacion = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $id_paciente = $stmt->fetchColumn();

        $stmt = $conn->prepare("DELETE FROM internacion WHERE id_internacion = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirige de nuevo al listado
        $_SESSION['mensaje'] = "registro de internacion eliminada correctamente.";
        $_SESSION['tipo_mensaje'] = "success";

        header("Location: ver_internacion.php?id_paciente=" . $id_paciente);
        exit;
    } catch (PDOException $e) {

        die("Error al eliminar internación: " . $e->getMessage());
    }
} else {
    die("ID inválido.");
}
