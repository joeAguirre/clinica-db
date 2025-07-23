<?php
    include_once('../sesiones/verificar_acesso.php');


    include_once('../conexion.php');
    include_once('../funciones/funcion-guardar.php');

    if($_SERVER['REQUEST_METHOD'] == "POST") {

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
       /*  $sql = "INSERT INTO paises (nombre) VALUES (:pais)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':pais', $pais);

        $guardar_pais = $stmt->execute() or die("Error al guardar el pais"); */

        $id_pais = insertarPais($conn, $pais);

        

        //insertar provincia

        $id_provincia = insertarProvincia($conn, $provincia, $id_pais);

        // insertar departamentos

        $id_departamento = insertarDepartamento($conn, $departamento, $id_provincia);


        // guardar municipio

        $id_municipio = insertarMunicipio($conn, $municipio, $id_departamento);


        //  guardar persona

        $id_persona = insertarPersona($conn, $nombre, $apellido, $fecha_nacimiento, $direccion, $telefono, $email, $id_municipio);

        // guardar paciente
        $guardar_paciente = insertarPaciente($conn, $id_persona, $id_obra_social, $num_afiliado, $id_tipo_sangre);
        
        if ($guardar_paciente) {
            $_SESSION['mensaje'] = 'Registro exitoso';

            header("Location: ./formulario-carga.php");
            exit();
        } else {
            $_SESSION['mensaje'] = 'Error en el registro.';
        }
    } else {
        // Si no se ha enviado el formulario, redirigir al formulario
        
        header("Location: ./formulario-carga.php");
        exit();
    }
?>