<?php
include_once('../../sesiones/verificar_acesso.php');

require_once '../../conexion.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Obtener id del paciente para redireccionar después
        $stmt = $conn->prepare("SELECT id_paciente FROM cita_medica WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $id_paciente = $stmt->fetchColumn();

        // Eliminar la cita médica
        $stmt = $conn->prepare("DELETE FROM cita_medica WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirige de nuevo al listado de citas del paciente
        $_SESSION['mensaje'] = "Cita médica eliminada correctamente.";
        $_SESSION['tipo_mensaje'] = "success";

        header("Location: ver_citas.php?id_paciente=" . $id_paciente);
        exit;
    } catch (PDOException $e) {
        die("Error al eliminar la cita médica: " . $e->getMessage());
    }
} else {
    die("ID inválido.");
}
