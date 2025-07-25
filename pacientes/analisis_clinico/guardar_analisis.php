<?php
require_once '../../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_paciente = $_POST['id_paciente'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'] ?? null;
    $resultado = $_POST['resultado'] ?? null;
    $fecha = $_POST['fecha'];

    try {
        $stmt = $conn->prepare("INSERT INTO analisis_clinico (id_paciente, tipo, descripcion, resultado, fecha)
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id_paciente, $tipo, $descripcion, $resultado, $fecha]);

        header("Location: ver_analisis.php?id_paciente=" . $id_paciente); 
        exit;
    } catch (PDOException $e) {
        die("Error al guardar análisis: " . $e->getMessage());
    }
} else {
    echo "Acceso no válido.";
}
