<?php

// eliminar medicos
function eliminarMedico($conn, $empleado_id) {
    try {
        $stmt = $conn->prepare("DELETE FROM medicos WHERE empleado_id = :id");
        $stmt->bindParam(':id', $empleado_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (\Throwable $th) {
        echo "No se pudo eliminar medico" . $th->getMessage();
    }
    

}

// funcion para eliminar el empleado
function eliminarEmpleado($conn, $empleado_id) {
    // Obtener ID de persona asociado
    $stmt = $conn->prepare("SELECT id_persona FROM empleados WHERE empleado_id = :id");
    $stmt->bindParam(':id', $empleado_id, PDO::PARAM_INT);
    $stmt->execute();
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$empleado) {
        throw new Exception("Empleado no encontrado.");
    }

    $id_persona = $empleado['id_persona'];

    // Eliminar de empleados
    $stmt = $conn->prepare("DELETE FROM empleados WHERE empleado_id = :id");
    $stmt->bindParam(':id', $empleado_id, PDO::PARAM_INT);
    $stmt->execute();

    return $id_persona;
}

// funcion para eliminar persona
    function eliminarPersona($conn, $id_persona) {
        $stmt = $conn->prepare("DELETE FROM personas WHERE id_persona = :id_persona");
        $stmt->bindParam(':id_persona', $id_persona, PDO::PARAM_INT);
        $stmt->execute();
    }


    // ELIMINAR PACIENTES
    
    function eliminarPaciente($conn, $id_paciente) {
    // Obtener id_persona antes de eliminar
    $stmt = $conn->prepare("SELECT id_persona FROM pacientes WHERE id_paciente = :id");
    $stmt->bindParam(':id', $id_paciente, PDO::PARAM_INT);
    $stmt->execute();
    $persona = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$persona) {
        throw new Exception("Paciente no encontrado.");
    }

    // Eliminar paciente
    $stmt = $conn->prepare("DELETE FROM pacientes WHERE id_paciente = :id");
    $stmt->bindParam(':id', $id_paciente, PDO::PARAM_INT);
    $stmt->execute();

    return $persona['id_persona'];
}

?>