<?php
session_start();
require_once '../conexion.php';
require_once('../funciones/funcion-eliminar.php');

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
       die("ID de empleado inválido.");
    }

    $empleado_id = (int) $_GET['id'];

    try {
    eliminarMedico($conn, $empleado_id);
    $id_persona = eliminarEmpleado($conn, $empleado_id);
    eliminarPersona($conn, $id_persona);

   
    $_SESSION['mensaje'] = "Empleado eliminado correctamente";
    $_SESSION['tipo_mensaje'] = "success";

    header("Location: buscar_empleados.php");
    exit;
    } catch (Exception $e) {
        echo "Error al eliminar: " . $e->getMessage();
    }

    
?>