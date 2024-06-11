<?php
    include_once('../conexion.php');

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        print_r($_POST);

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $tipo_sangre = $_POST['tipo_sangre'];
       $id_municipio = $_POST['municipio'];

       echo $id_municipio . "<br>";

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

        if ($stmt->execute()) {
            echo "persona guardada correctamente";
        } else {
            echo "No se pudo guardar el registro";
        }
        
        echo $nombre . $apellido . $fecha_nacimiento;
    }
?>