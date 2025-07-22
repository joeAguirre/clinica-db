<?php
session_start();
include('../conexion.php');

include_once('../sesiones/verificar_acesso.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_empleado = intval($_POST['id_empleado']);
    $horarios = $_POST['horario'] ?? [];

    try {
        $conn->beginTransaction();

        // Eliminar cronograma previo
        $stmtDelete = $conn->prepare("DELETE FROM cronograma_empleado WHERE id_empleado = :id_empleado");
        $stmtDelete->execute([':id_empleado' => $id_empleado]);

        // Preparar inserción
        $stmtInsert = $conn->prepare("INSERT INTO cronograma_empleado (id_empleado, id_dia, hora_entrada, hora_salida)
            VALUES (:id_empleado, :id_dia, :hora_entrada, :hora_salida)");

        foreach ($horarios as $id_dia => $horario) {
            $stmtInsert->execute([
                ':id_empleado' => $id_empleado,
                ':id_dia' => $id_dia,
                ':hora_entrada' => $horario['entrada'],
                ':hora_salida' => $horario['salida']
            ]);
        }

        $conn->commit();
        $_SESSION['mensaje'] = "Cronograma guardado correctamente.";
        $_SESSION['tipo_mensaje'] = "success";
    } catch (Exception $e) {
        $conn->rollBack();
        $_SESSION['mensaje'] = "Error al guardar cronograma: " . $e->getMessage();
        $_SESSION['tipo_mensaje'] = "danger";
    }

    header("Location: ver_cronograma.php?empleado_id=$id_empleado");
    exit;
}
