<?php
session_start();
require_once '../conexion.php';
require_once('../funciones/funcion-eliminar.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de paciente inválido.");
}

$id_paciente = (int) $_GET['id'];

try {

    // 2. Eliminar paciente
    $id_persona = eliminarPaciente($conn, $id_paciente);

    // 3. Eliminar persona asociada
    eliminarPersona($conn, $id_persona);

    $_SESSION['mensaje'] = "Paciente eliminado correctamente.";
    $_SESSION['tipo_mensaje'] = "success";

    header("Location: buscar_pacientes.php");
    exit;
} catch (Exception $e) {
    echo "Error al eliminar: " . $e->getMessage();
}
