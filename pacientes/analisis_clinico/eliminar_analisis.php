<?php
session_start();
require_once '../../conexion.php';

if (!isset($_GET['id_analisis']) || !is_numeric($_GET['id_analisis'])) {
    die("ID de análisis no válido.");
}

$id_analisis = (int) $_GET['id_analisis'];

try {
    // Obtenemos el id_paciente
    $stmt = $conn->prepare("SELECT id_paciente FROM analisis_clinico WHERE id_analisis = :id");
    $stmt->bindParam(':id', $id_analisis, PDO::PARAM_INT);
    $stmt->execute();
    $id_paciente = $stmt->fetchColumn();

    if (!$id_paciente) {
        die("No se encontró el análisis clínico.");
    }

    // Eliminamos el análisis
    $stmt = $conn->prepare("DELETE FROM analisis_clinico WHERE id_analisis = :id");
    $stmt->bindParam(':id', $id_analisis, PDO::PARAM_INT);
    $stmt->execute();
    
    $_SESSION['mensaje'] = "analisis eliminado corectamente.";
    $_SESSION['tipo_mensaje'] = "success";

    // Redirigimos
    header("Location: ver_analisis.php?id_paciente=$id_paciente");
    exit;

} catch (PDOException $e) {
    echo "Error al eliminar: " . $e->getMessage();
}
