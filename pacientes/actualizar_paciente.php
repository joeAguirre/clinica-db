<?php
include_once('../sesiones/verificar_acesso.php');

include '../conexion.php';
include_once('../funciones/funcion-actualizar.php');

$id_pais = $_POST['id_pais'];
$pais = $_POST['pais'];

$id_provincia = $_POST['id_provincia'];
$provincia = $_POST['provincia'];

$id_departamento = $_POST['id_departamento'];
$departamento = $_POST['departamento'];

$id_municipio = $_POST['id_municipio'];
$municipio = $_POST['municipio'];

$id_persona = $_POST['id_persona'];
$id_paciente = $_POST['id_paciente'];

try {
    // Actualizar jerarquía geográfica
    actualizarPais($conn, $id_pais, $pais);
    actualizarProvincia($conn, $id_provincia, $provincia, $id_pais);
    actualizarDepartamento($conn, $id_departamento, $departamento, $id_provincia);
    actualizarMunicipio($conn, $id_municipio, $municipio, $id_departamento); 

    // Actualizar persona y paciente
    actualizarPersona($conn, $_POST, $id_persona);
    actualizarPaciente($conn, $_POST, $id_paciente);

    $_SESSION['mensaje'] = "Paciente actualizado correctamente.";
    $_SESSION['tipo_mensaje'] = "success";
    header("Location: buscar_pacientes.php");

} catch (\Throwable $th) {
    echo "No se pudo actualizar: " . $th->getMessage();
}
?>
