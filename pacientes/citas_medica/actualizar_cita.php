<?php
include_once('../../sesiones/verificar_acesso.php');
require_once '../../conexion.php';

// Verificar si se recibió un ID válido
    if (!isset($_POST['id_cita']) || !is_numeric($_POST['id_cita'])) {
        die("ID de la cita no válido.");
    }

if (!isset($_POST['id_paciente']) || !is_numeric($_POST['id_paciente'])) {
    die("ID del paciente no válido.");
}

$id_cita = (int) $_POST['id_cita'];
$id_paciente = (int) $_POST['id_paciente'];

// Validar y sanitizar campos
    $id_medico = isset($_POST['id_medico']) ? (int) $_POST['id_medico'] : 0;
    $fecha = trim($_POST['fecha'] ?? '');
    $hora = trim($_POST['hora'] ?? '');

    if (empty($fecha) || empty($hora) || $id_medico <= 0) {
        die("Te falta rellenar campos.");
    }

try {
    $stmt = $conn->prepare("
        UPDATE cita_medica 
        SET id_medico = :id_medico, fecha = :fecha, hora = :hora
        WHERE id = :id_cita
    ");

    $stmt->bindParam(':id_medico', $id_medico, PDO::PARAM_INT);
    $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bindParam(':hora', $hora, PDO::PARAM_STR);
    $stmt->bindParam(':id_cita', $id_cita, PDO::PARAM_INT);

    $stmt->execute();

    $_SESSION['mensaje'] = "Cita actualizada correctamente.";
    $_SESSION['tipo_mensaje'] = "success";

    header("Location: ver_citas.php?id_paciente=" . $id_paciente);
    exit;

} catch (PDOException $e) {
    echo "Error al actualizar: " . $e->getMessage();
}
