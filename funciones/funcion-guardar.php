<?php
include_once('../conexion.php');


// INSERTAR PAIS
function insertarPais($conn, $nombrePais) {
    try {
        $sql = "INSERT INTO paises (nombre) VALUES (:pais)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pais', $nombrePais);

        $stmt->execute();

        return $conn->lastInsertId();
    } catch (PDOException $e) {
       
        echo "Error al insertar país: " . $e->getMessage();
        return false;
    }
}

// INSERTAR PROVINCIA

function insertarProvincia($conn, $nombreProvincia, $idPais) {
    try {
        $sql = "INSERT INTO provincias (nombre, id_pais) VALUES (:provincia, :id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':provincia', $nombreProvincia);
        $stmt->bindParam(':id', $idPais);
        $stmt->execute();
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        echo "Error al insertar provincia: " . $e->getMessage();
        return false;
    }
}

// INSERTAR DEPARTAMENTO

function insertarDepartamento($conn, $nombreDepartamento, $idProvincia) {
    try {
        $sql = "INSERT INTO departamentos (nombre, id_provincia) VALUES (:departamento, :id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':departamento', $nombreDepartamento);
        $stmt->bindParam(':id', $idProvincia);
        $stmt->execute();
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        echo "Error al insertar departamento: " . $e->getMessage();
        return false;
    }
}

// INSERTAR MUNICIPIO

function insertarMunicipio($conn, $nombreMunicipio, $idDepartamento) {
    try {
        $sql = "INSERT INTO municipio (nombre, id_departamento) VALUES (:nombre, :id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombreMunicipio);
        $stmt->bindParam(':id', $idDepartamento);
        $stmt->execute();
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        echo "Error al insertar municipio: " . $e->getMessage();
        return false;
    }
}
// INSERTAR PERSONA

function insertarPersona($conn, $nombre, $apellido, $fecha_nacimiento, $direccion, $telefono, $email, $id_municipio) {
    try {
        $sql = "INSERT INTO personas (nombre, apellido, fecha_nacimiento, direccion, telefono, email, id_municipio)
                VALUES (:nombre, :apellido, :fecha_nacimiento, :direccion, :telefono, :email, :id_municipio)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id_municipio', $id_municipio);
        $stmt->execute();
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        echo "Error al insertar persona: " . $e->getMessage();
        return false;
    }
}

// INSERTAR PACIENTE

function insertarPaciente($conn, $id_persona, $id_obra_social, $numero_afiliado, $id_tipo_sangre) {
    try {
        $sql = "INSERT INTO pacientes (id_persona, numero_afiliado, id_obra_social, id_tipo_sangre)
                VALUES (:id_per, :num_af, :id_obra, :id_sangre)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_per', $id_persona);
        $stmt->bindParam(':num_af', $numero_afiliado);
        $stmt->bindParam(':id_obra', $id_obra_social);
        $stmt->bindParam(':id_sangre', $id_tipo_sangre);
        if ($stmt->execute()) {
            return $conn->lastInsertId();
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Error al insertar paciente: " . $e->getMessage();
        return false;
    }
}

//INSERTAR EMPLEADO
function insertarEmpleado($conn, $persona_id) {
    try {
        $sql = "INSERT INTO empleados (id_persona) VALUES (:id_persona)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_persona', $persona_id);
        $stmt->execute();
        return $conn->lastInsertId();
    } catch (PDOException $e) {
        throw new Exception("Error al insertar empleado: " . $e->getMessage());
    }
}


// INSERTAR MEDICO
function insertarMedico($conn, $empleado_id, $especialidad, $codigo_medico) {
    try {

        $sql = "INSERT INTO medicos (empleado_id, id_especialidad, codigo_medico)
                VALUES (:empleado_id, :id_especialidad, :codigo_medico)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':empleado_id', $empleado_id);
        $stmt->bindParam(':id_especialidad', $especialidad);
        $stmt->bindParam(':codigo_medico', $codigo_medico);
        $stmt->execute();

        return $conn->lastInsertId();
    } catch (PDOException $e) {
        throw new Exception("Error al insertar médico: " . $e->getMessage());
    }
}



?>
