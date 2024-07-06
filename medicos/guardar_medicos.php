<?php
// Incluir archivo de conexión a la base de datos
include_once('../conexion.php');

session_start();


 if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'] ?? null; 
    $telefono = $_POST['telefono'] ?? null;
    $email = $_POST['email'] ?? null;
    $especialidad = $_POST['especialidad'];
    $codigo_medico = $_POST['codigo_medico'];


    $sql_personas = "INSERT INTO personas (nombre, apellido, fecha_nacimiento, direccion, telefono, email)
                     VALUES (:nombre, :apellido, :fecha_nacimiento, :direccion, :telefono, :email)";

    
    $sql_empleados = "INSERT INTO empleados (id_persona) VALUES (:id_persona)";

    
    $sql_medicos = "INSERT INTO medicos (empleado_id, especialidad, codigo_medico)
                    VALUES (:empleado_id, :especialidad, :codigo_medico)";

    try {
        // Iniciar una transacción
        $conn->beginTransaction();

        // Insertar primero en la tabla personas
        $stmt = $conn->prepare($sql_personas);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

     
        $persona_id = $conn->lastInsertId(); 

        // Insertar en la tabla empleados 
        $stmt = $conn->prepare($sql_empleados);
        $stmt->bindParam(':id_persona', $persona_id);
        $stmt->execute();
        $empleado_id = $conn->lastInsertId(); 


     // Insertar en la tabla medicos 
        $stmt = $conn->prepare($sql_medicos);
        $stmt->bindParam(':empleado_id', $empleado_id);
        $stmt->bindParam(':especialidad', $especialidad);
        $stmt->bindParam(':codigo_medico', $codigo_medico);
        $stmt->execute();

       
        $conn->commit();

        $_SESSION['mensaje'] = "Médico registrado correctamente.";

        //redirigir 
        header("location:./agregar_medicos.php");

    } catch (PDOException $e) {
        
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    // Cerrar la conexión
    $conn = null;

} else {
    // Si no se reciben datos por POST, redirigir o mostrar un mensaje de error
    echo "Error: No se recibieron datos por POST.";
} 
?>
