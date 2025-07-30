<?php
include_once('../sesiones/verificar_acesso.php');

include '../conexion.php';
    include_once("../plantilla/header.php");

    if (isset($_GET['id'])) {
        $id_empleado = $_GET['id'];
    } else {
        die("ID de análisis no válido.");
    }
    

    $stmt = $conn->prepare("
    SELECT e.empleado_id, e.codigo_empleado, e.estado,
            pe.id_persona, pe.nombre, pe.apellido, pe.fecha_nacimiento, pe.direccion, pe.telefono, pe.email,
            mu.nombre AS municipio,mu.id_municipio, de.nombre AS departamento, de.id_departamento, pr.nombre AS provincia,pr.id_provincia,
             pa.nombre AS pais, pa.id_pais
    FROM empleados e
    JOIN personas pe ON e.id_persona = pe.id_persona
    JOIN municipio mu ON pe.id_municipio = mu.id_municipio
    JOIN departamentos de ON mu.id_departamento = de.id_departamento
    JOIN provincias pr ON de.id_provincia = pr.id_provincia
    JOIN paises pa ON pr.id_pais = pa.id_pais
    WHERE e.empleado_id = ?
    ");
    $stmt->execute([$id_empleado]);
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);


?>


<div class="container">
    <h2 class="text-center">Editar Empleado</h2>
    <form action="./actualizar_empleado.php" method="post">
        <!-- Campo oculto con el ID del empleado -->
        <input type="hidden" name="id_empleado" value="<?php echo $empleado['empleado_id']; ?>">
        <input type="hidden" name="id_persona" value="<?php echo $empleado['id_persona']; ?>">

       <!-- obtenemos los id -->
        <input type="hidden" name="id_pais" value="<?php echo $empleado['id_pais']; ?>">
        <input type="hidden" name="id_provincia" value="<?php echo $empleado['id_provincia']; ?>">
        <input type="hidden" name="id_departamento" value="<?php echo $empleado['id_departamento']; ?>">
        <input type="hidden" name="id_municipio" value="<?php echo $empleado['id_municipio']; ?>">
        

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-z\s]+" value="<?php echo htmlspecialchars($empleado['nombre']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required pattern="[A-Za-z\s]+" value="<?php echo htmlspecialchars($empleado['apellido']); ?>">
            </div>
        </div>

        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required value="<?php echo $empleado['fecha_nacimiento']; ?>">
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($empleado['direccion']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo htmlspecialchars($empleado['telefono']); ?>">
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($empleado['email']); ?>">
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado" required>
                <option value="1" <?php echo $empleado['estado'] == 1 ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo $empleado['estado'] == 0 ? 'selected' : ''; ?>>Inactivo</option>
            </select>
        </div>

        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="pais" class="form-label">País</label>
                <input type="text" class="form-control" id="pais" name="pais" value="<?php echo htmlspecialchars($empleado['pais']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label for="provincia" class="form-label">Provincia</label>
                <input type="text" class="form-control" id="provincia" name="provincia" value="<?php echo htmlspecialchars($empleado['provincia']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label for="departamento" class="form-label">Departamento</label>
                <input type="text" class="form-control" id="departamento" name="departamento" value="<?php echo htmlspecialchars($empleado['departamento']); ?>">
            </div>
            <div class="mb-3 col-md-6">
                <label for="municipio" class="form-label">Municipio</label>
                <input type="text" class="form-control" id="municipio" name="municipio" value="<?php echo htmlspecialchars($empleado['municipio']); ?>">
            </div>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="../index.php" class="btn btn-secondary">Volver</a>
        </div>
    </form>
</div>

<?php
    include_once("../plantilla/footer.php");
?>

