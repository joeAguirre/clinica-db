<?php

require '../conexion.php'; 

include_once('../sesiones/verificar_acesso.php');
include_once('../funciones/funcion-guardar.php');



if($_SERVER['REQUEST_METHOD'] == 'POST'){
     // Datos de persona
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];

    // Datos de empleado
    $estado = $_POST['estado'];

    // Datos de ubicación
    $pais = $_POST['pais'] ?? null;
    $provincia = $_POST['provincia'] ?? null;
    $departamento = $_POST['departamento'] ?? null;
    $municipio = $_POST['municipio'] ?? null;


    try {
         $conn->beginTransaction();

        // Insertar en la tabla paises
        $id_pais = insertarPais($conn, $pais);

        // Insertar en la tabla provincias
        $id_provincia = insertarProvincia($conn, $provincia, $id_pais);

        // Insertar en la tabla departamentos
        $id_departamento = insertarDepartamento($conn, $departamento, $id_provincia);

        // Insertar en la tabla municipios
        $id_municipio = insertarMunicipio($conn, $municipio, $id_departamento);
    
        // Insertar en la tabla personas
        $persona_id = insertarPersona($conn, $nombre, $apellido, $fecha_nacimiento, $direccion, $telefono, $email, $id_municipio);
    
        // Insertar en la tabla empleados
        $id_empleado = insertarEmpleado($conn, $persona_id, $estado);
    
        $conn->commit();
        // Establecer un mensaje de éxito en la sesión
        $_SESSION['mensaje'] = "Empleado agregado exitosamente.";
    
    } catch (Throwable $e) {
        if ($conn && $conn->inTransaction()) {
            $conn->rollback();
        }
        $_SESSION['mensaje'] = "Error al agregar el empleado: " . $e->getMessage();
    }
} else {
    header("Location: carga-empleados.php");
}


  header("Location: carga-empleados.php");
exit;
?>
