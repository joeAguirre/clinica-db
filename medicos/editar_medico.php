<?php
session_start();
include_once('../conexion.php');
// include_once('../sesiones/verificar_acesso.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido");
}

$empleado_id = $_GET['id'];

// Obtener datos del médico, persona y especialidad
$sql = "SELECT personas.*, empleados.*, medicos.codigo_medico, medicos.id_especialidad, medicos.id_medico,
       municipio.nombre AS municipio, municipio.id_municipio, departamentos.nombre AS departamento,
       departamentos.id_departamento, provincias.id_provincia,
       provincias.nombre AS provincia, paises.nombre AS pais, paises.id_pais
        FROM empleados
        JOIN personas ON personas.id_persona = empleados.id_persona
        LEFT JOIN municipio ON municipio.id_municipio = personas.id_municipio
        LEFT JOIN departamentos ON departamentos.id_departamento = municipio.id_departamento
        LEFT JOIN provincias ON provincias.id_provincia = departamentos.id_provincia
        LEFT JOIN paises ON paises.id_pais = provincias.id_pais
        JOIN medicos ON medicos.empleado_id = empleados.empleado_id
        WHERE empleados.empleado_id = :id
        ";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $empleado_id, PDO::PARAM_INT);
$stmt->execute();
$medico = $stmt->fetch(PDO::FETCH_ASSOC);

print_r($medico);

if (!$medico) {
    die("Médico no encontrado.");
}

// Obtener lista de especialidades
$especialidades = $conn->query("SELECT id_especialidad, nombre FROM especialidades")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Actualizar Médico</h2>
    <form action="actualizar_medico.php" method="post">
        <input type="hidden" name="id_persona" value="<?= htmlspecialchars($medico['id_persona']) ?>">
        <input type="hidden" name="id_empleado" value="<?= htmlspecialchars($empleado_id) ?>">
        <input type="hidden" name="id_medico" value="<?= htmlspecialchars($medico['id_medico']) ?>">

         <input type="hidden" name="id_pais" value="<?php echo $medico['id_pais']; ?>">
        <input type="hidden" name="id_provincia" value="<?php echo $medico['id_provincia']; ?>">
        <input type="hidden" name="id_departamento" value="<?php echo $medico['id_departamento']; ?>">
        <input type="hidden" name="id_municipio" value="<?php echo $medico['id_municipio']; ?>">

        <div class="row">
            <div class="mb-3 col-md-6">
                <label>Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($medico['nombre']) ?>" required>
            </div>
            <div class="mb-3 col-md-6">
                <label>Apellido</label>
                <input type="text" class="form-control" name="apellido" value="<?= htmlspecialchars($medico['apellido']) ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Fecha de nacimiento</label>
            <input type="date" class="form-control" name="fecha_nacimiento" value="<?= $medico['fecha_nacimiento'] ?>" required>
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label>Dirección</label>
                <input type="text" class="form-control" name="direccion" value="<?= htmlspecialchars($medico['direccion']) ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label>Teléfono</label>
                <input type="text" class="form-control" name="telefono" value="<?= htmlspecialchars($medico['telefono']) ?>">
            </div>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($medico['email']) ?>">
        </div>

        <div class="mb-3">
            <label>Especialidad</label>
            <select class="form-select" name="especialidad">
                <?php foreach ($especialidades as $esp): ?>
                    <option value="<?= $esp['id_especialidad'] ?>" <?= $esp['id_especialidad'] == $medico['id_especialidad'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($esp['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Código Médico</label>
            <input type="text" class="form-control" name="codigo_medico" value="<?= htmlspecialchars($medico['codigo_medico']) ?>" required>
        </div>

        <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value=1>Activo</option>
                    <option value=0>Inactivo</option>
                </select>
            </div> 

        <div class="row">
            <div class="mb-3 col-md-6">
                <label>País</label>
                <input type="text" class="form-control" name="pais" value="<?= htmlspecialchars($medico['pais']) ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label>Provincia</label>
                <input type="text" class="form-control" name="provincia" value="<?php echo $medico['provincia'] ? htmlspecialchars($medico['provincia']) : '' ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label>Departamento</label>
                <input type="text" class="form-control" name="departamento" value="<?= htmlspecialchars($medico['departamento']) ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label>Municipio</label>
                <input type="text" class="form-control" name="municipio" value="<?= htmlspecialchars($medico['municipio']) ?>">
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="buscar_medicos.php" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>
</body>
</html>
