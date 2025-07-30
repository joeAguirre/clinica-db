<?php
include_once('../../sesiones/verificar_acesso.php');
require_once '../../conexion.php';


    // Verificar si se recibió un ID válido
    if (!isset($_POST['id_analisis']) || !is_numeric($_POST['id_analisis'])) {
        die("ID de análisis no válido.");
    }

    if (!isset($_POST['id_paciente']) || !is_numeric($_POST['id_paciente'])) {
        die("ID del paciente no válido.");
    }

    $id = (int) $_POST['id_analisis'];
    $id_paciente = (int) $_POST['id_paciente'];

    // Validar y sanitizar campos
    $tipo = trim($_POST['tipo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $resultado = trim($_POST['resultado'] ?? '');
    $fecha = $_POST['fecha'] ?? '';

    if (empty($tipo) || empty($fecha)) {
        die("Los campos 'tipo' y 'fecha' son obligatorios.");
    }

    try {
        $stmt = $conn->prepare("
            UPDATE analisis_clinico 
            SET tipo = :tipo, descripcion = :descripcion, resultado = :resultado, fecha = :fecha
            WHERE id_analisis = :id
        ");

        $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':resultado', $resultado, PDO::PARAM_STR);
        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        $_SESSION['mensaje'] = "analisis actualizado correctamente.";
        $_SESSION['tipo_mensaje'] = "success";

        header("Location: ver_analisis.php?id_paciente=" . $id_paciente);
        exit;

    } catch (PDOException $e) {
        echo "Error al actualizar: " . $e->getMessage();
    }

