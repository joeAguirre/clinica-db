<?php
session_start();
require '../conexion.php'; 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {

        $sql_persona = "INSERT INTO personas (nombre, apellido, fecha_nacimiento, direccion, telefono, email)
                        VALUES (:nombre, :apellido, :fecha_nacimiento, :direccion, :telefono, :email)";
        $stmt_persona = $conn->prepare($sql_persona);
    
        
        $stmt_persona->execute([
            ':nombre' => $_POST['nombre'],
            ':apellido' => $_POST['apellido'],
            ':fecha_nacimiento' => $_POST['fecha_nacimiento'],
            ':direccion' => $_POST['direccion'],
            ':telefono' => $_POST['telefono'],
            ':email' => $_POST['email'],
        ]);
    
        $persona_id = $conn->lastInsertId();
    
        $sql_empleado = "INSERT INTO empleados ( id_persona, codigo_empleado, estado)
                         VALUES (:id_persona, :codigo_empleado, :estado)";
        $stmt_empleado = $conn->prepare($sql_empleado);
    
        $stmt_empleado->execute([
            ':id_persona' => $persona_id,
            ':codigo_empleado' => $_POST['codigo_empleado'],
            ':estado' => $_POST['estado'],
        ]);
    
        // Establecer un mensaje de éxito en la sesión
        $_SESSION['mensaje'] = "Empleado agregado exitosamente.";
    
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error al agregar el empleado: " . $e->getMessage();
    }
} else {
    header("Location: carga-empleados.php");
}


  header("Location: carga-empleados.php");
exit;
?>
