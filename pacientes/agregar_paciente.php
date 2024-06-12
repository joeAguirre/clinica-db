<?php
    include_once('../conexion.php');

    session_start();

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        print_r($_POST);

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $tipo_sangre = $_POST['tipo_sangre'];
        $municipio = $_POST['municipio'];
        $departamento = $_POST['departamento'];
        $provincia = $_POST['provincias'];
        $pais = $_POST['pais'];
        $id_obra_social = $_POST['obra_social'];
        $num_afiliado = $_POST['num_afiliado'];
        $id_tipo_sangre = $_POST['tipo_sangre'];

         // insertar pais
        $sql = "INSERT INTO paises (nombre) VALUES (:pais)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pais', $pais);

        $guardar_pais = $stmt->execute() or die("Error al guardar el pais");

        $id_pais = $conn->lastInsertId();

        echo "<br>" . $id_pais . "<br>";

        //insertar provincia

         $sql = "INSERT INTO provincias (nombre, id_pais) VALUES (:provincia, :id)";
         $stmt = $conn->prepare($sql);
         $stmt->bindParam(':provincia', $provincia);
         $stmt->bindParam(':id', $id_pais);

        $guardar_provincia = $stmt->execute() or die("Error al guardar la provincia");

        $id_provincia = $conn->lastInsertId();

        // insertar departamentos

        $sql = "INSERT INTO departamentos (nombre, id_provincia) VALUES (:departamento, :id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':departamento', $departamento);
        $stmt->bindParam(':id', $id_provincia);

        $guardar_departamento = $stmt->execute() or die("Error al guardar el departamento");

        $id_departamento = $conn->lastInsertId();


        // guardar municipio

         $sql = "INSERT INTO municipio (nombre, id_departamento) VALUES (:nombre, :id)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nombre', $municipio);
        $stmt->bindParam(':id', $id_departamento);
        
        $guardar_municipio = $stmt->execute() or die("Error al guardar el municipio");

        $id_municipio = $conn->lastInsertId();


        //  guardar persona

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
        
        $guardar_persona = $stmt->execute() or die("Error al guardar la persona");

        $id_persona = $conn->lastInsertId();

        // guardar paciente
        $sql = "INSERT INTO pacientes (id_persona, numero_afiliado, id_obra_social, id_tipo_sangre) VALUES (:id_per, :num_af,:id_obra,:id_sangre)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_per', $id_persona);
        $stmt->bindParam(':num_af', $num_afiliado);
        $stmt->bindParam(':id_obra', $id_obra_social);
        $stmt->bindParam(':id_sangre', $id_tipo_sangre);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = 'Registro exitoso';

            header("Location: ./formulario-carga.php");
            exit();
        } else {
            $_SESSION['mensaje'] = 'Error en el registro: ';
        }
        
    } else {
        // Si no se ha enviado el formulario, redirigir al formulario
        
        header("Location: ./formulario-carga.php");
        exit();
    }
?>