<?php

// actualizar pais
function actualizarPais($conn, $idPais, $nuevoNombre) {
    try {
        $sql = "UPDATE paises SET nombre = :nombre WHERE id_pais = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nuevoNombre);
        $stmt->bindParam(':id', $idPais);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al actualizar país: " . $e->getMessage();
        return false;
    }
}

// actualizar provincias
function actualizarProvincia($conn, $idProvincia, $nuevoNombre, $idPais) {
    try {
        $sql = "UPDATE provincias SET nombre = :nombre, id_pais = :idPais WHERE id_provincia = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nuevoNombre);
        $stmt->bindParam(':idPais', $idPais);
        $stmt->bindParam(':id', $idProvincia);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al actualizar provincia: " . $e->getMessage();
        return false;
    }
}

// actualizar departamentos

function actualizarDepartamento($conn, $idDepartamento, $nuevoNombre, $idProvincia) {
    try {
        $sql = "UPDATE departamentos SET nombre = :nombre, id_provincia = :idProvincia WHERE id_departamento = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nuevoNombre);
        $stmt->bindParam(':idProvincia', $idProvincia);
        $stmt->bindParam(':id', $idDepartamento);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al actualizar departamento: " . $e->getMessage();
        return false;
    }
}

// actualizar municipio

function actualizarMunicipio($conn, $idMunicipio, $nuevoNombre, $idDepartamento) {
    try {
        $sql = "UPDATE municipio SET nombre = :nombre, id_departamento = :idDepartamento WHERE id_municipio = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nuevoNombre);
        $stmt->bindParam(':idDepartamento', $idDepartamento);
        $stmt->bindParam(':id', $idMunicipio);
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "Error al actualizar municipio: " . $e->getMessage();
        return false;
    }
}


// actualizar personas

function actualizarPersona($conn, $datos, $id_persona) {
    $stmt = $conn->prepare("
        UPDATE personas SET
            nombre = ?, apellido = ?, fecha_nacimiento = ?, direccion = ?, telefono = ?, email = ?
        WHERE id_persona = ?
    ");
    return $stmt->execute([
        $datos['nombre'],
        $datos['apellido'],
        $datos['fecha_nacimiento'],
        $datos['direccion'],
        $datos['telefono'],
        $datos['email'],
        $id_persona
    ]);
}


// actualizar empleados

function actualizarEmpleado($conn, $datos, $empleado_id) {
    $stmt = $conn->prepare("
        UPDATE empleados SET
         estado = ?
        WHERE empleado_id = ?
    ");
    return $stmt->execute([
        $datos['estado'],
        $empleado_id
    ]);
}


// ACTUALIZAR PACIENTE

function actualizarPaciente($conn, $datos, $id_paciente) {
    $sql = "UPDATE pacientes SET 
                numero_afiliado = :numero_afiliado,
                id_obra_social = :id_obra_social,
                id_tipo_sangre = :id_tipo_sangre
            WHERE id_paciente = :id_paciente";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':numero_afiliado', $datos['numero_afiliado']);
    $stmt->bindParam(':id_obra_social', $datos['id_obra_social']);
    $stmt->bindParam(':id_tipo_sangre', $datos['id_tipo_sangre']);
    $stmt->bindParam(':id_paciente', $id_paciente);
    
    $stmt->execute();
}


// ACTUALIZAR MEDICO

function actualizarMedico($conn, $data, $id_medico) {
    $sql = "UPDATE medicos SET codigo_medico = :codigo_medico, id_especialidad = :id_especialidad WHERE id_medico = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo_medico', $data['codigo_medico']);
    $stmt->bindParam(':id_especialidad', $data['especialidad']);
    $stmt->bindParam(':id', $id_medico);
    $stmt->execute();
}




?>
