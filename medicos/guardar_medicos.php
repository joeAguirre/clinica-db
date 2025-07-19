<?php
// Incluir archivo de conexión a la base de datos
include_once('../conexion.php');
include_once('../funciones/funcion-guardar.php');

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



 if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'] ?? null; 
    $telefono = $_POST['telefono'] ?? null;
    $email = $_POST['email'] ?? null;
    $especialidad = $_POST['especialidad'];
    $codigo_medico = $_POST['codigo_medico'];
    $estado = $_POST['estado'] ?? 1; // Por defecto activo
    $pais = $_POST['pais'] ?? null;
    $provincia = $_POST['provincia'] ?? null;
    $departamento = $_POST['departamento'] ?? null;
    $municipio = $_POST['municipio'] ?? null;


    try {
        // Iniciar una transacción
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
        $persona_id = insertarPersona($conn, $nombre, $apellido, $fecha_nacimiento, $direccion, $telefono, $email, null); 

        // Insertar en la tabla empleados 
        $empleado_id = insertarEmpleado($conn, $persona_id, $estado);


     // Insertar en la tabla medicos 
        $medico_id = insertarMedico($conn, $empleado_id, $especialidad, $codigo_medico);

       
        $conn->commit();

        $_SESSION['mensaje'] = "Médico registrado correctamente.";

        //redirigir 
         header("location:./agregar_medicos.php");

    } catch (Throwable $e) {
     if ($conn && $conn->inTransaction()) {
            $conn->rollback();
        }
    $_SESSION['mensaje'] = "Error al registrar medico: " . $e->getMessage();
    header("location:./agregar_medicos.php");
    exit();
}

    // Cerrar la conexión
    $conn = null;

} else {
    echo "Error: No se recibieron datos por POST.";
} 
?>
