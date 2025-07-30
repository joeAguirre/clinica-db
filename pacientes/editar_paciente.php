<?php
include '../conexion.php';
include_once("../plantilla/header.php");

$id_paciente = $_GET['id'];

// Obtener datos del paciente con info de persona y lugar
$stmt = $conn->prepare("
    SELECT pa.id_paciente, pa.numero_afiliado, pa.id_obra_social, pa.id_tipo_sangre,
           pe.id_persona, pe.nombre, pe.apellido, pe.fecha_nacimiento, pe.direccion, pe.telefono, pe.email,
           mu.id_municipio, mu.nombre AS municipio,
           de.id_departamento, de.nombre AS departamento,
           pr.id_provincia, pr.nombre AS provincia,
           ps.id_pais, ps.nombre AS pais
    FROM pacientes pa
    JOIN personas pe ON pa.id_persona = pe.id_persona
    JOIN municipio mu ON pe.id_municipio = mu.id_municipio
    JOIN departamentos de ON mu.id_departamento = de.id_departamento
    JOIN provincias pr ON de.id_provincia = pr.id_provincia
    JOIN paises ps ON pr.id_pais = ps.id_pais
    WHERE pa.id_paciente = ?
");
$stmt->execute([$id_paciente]);
$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener obras sociales
$obras_stmt = $conn->query("SELECT * FROM obra_social");
$obras = $obras_stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener tipos de sangre
$tipos_stmt = $conn->query("SELECT * FROM tipo_sangre");
$tipos = $tipos_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-3" style="background-color: #0799b6; max-width: 900px">
    <h2 class="text-center">Editar Paciente</h2>
    <form action="actualizar_paciente.php" method="post">
        <!-- IDs ocultos -->
        <input type="hidden" name="id_paciente" value="<?php echo $paciente['id_paciente']; ?>">
        <input type="hidden" name="id_persona" value="<?php echo $paciente['id_persona']; ?>">
        <input type="hidden" name="id_pais" value="<?php echo $paciente['id_pais']; ?>">
        <input type="hidden" name="id_provincia" value="<?php echo $paciente['id_provincia']; ?>">
        <input type="hidden" name="id_departamento" value="<?php echo $paciente['id_departamento']; ?>">
        <input type="hidden" name="id_municipio" value="<?php echo $paciente['id_municipio']; ?>">

        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required pattern="[A-Za-z\s]+" value="<?php echo htmlspecialchars($paciente['nombre']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Apellido</label>
                <input type="text" class="form-control" name="apellido" required pattern="[A-Za-z\s]+" value="<?php echo htmlspecialchars($paciente['apellido']); ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" name="fecha_nacimiento" required value="<?php echo $paciente['fecha_nacimiento']; ?>">
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccion" value="<?php echo htmlspecialchars($paciente['direccion']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono" value="<?php echo htmlspecialchars($paciente['telefono']); ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($paciente['email']); ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Número de Afiliado</label>
            <input type="text" class="form-control" name="numero_afiliado" value="<?php echo htmlspecialchars($paciente['numero_afiliado']); ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Obra Social</label>
            <select class="form-select" name="id_obra_social" required>
                <?php foreach ($obras as $obra): ?>
                    <option value="<?php echo $obra['id_obra_social']; ?>"
                        <?php if ($obra['id_obra_social'] == $paciente['id_obra_social']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($obra['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de Sangre</label>
            <select class="form-select" name="id_tipo_sangre" required>
                <?php foreach ($tipos as $tipo): ?>
                    <option value="<?php echo $tipo['id_tipo_sangre']; ?>"
                        <?php if ($tipo['id_tipo_sangre'] == $paciente['id_tipo_sangre']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($tipo['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Ubicación -->
        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">País</label>
                <input type="text" class="form-control" name="pais" value="<?php echo htmlspecialchars($paciente['pais']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Provincia</label>
                <input type="text" class="form-control" name="provincia" value="<?php echo htmlspecialchars($paciente['provincia']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Departamento</label>
                <input type="text" class="form-control" name="departamento" value="<?php echo htmlspecialchars($paciente['departamento']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Municipio</label>
                <input type="text" class="form-control" name="municipio" value="<?php echo htmlspecialchars($paciente['municipio']); ?>">
            </div>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="../index.php" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>

<?php include_once("../plantilla/footer.php"); ?>
