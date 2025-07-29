<?php
include_once('../sesiones/verificar_acesso.php');
include '../conexion.php';
include '../plantilla/header.php';

// Verificar que llega el ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container mt-5 alert alert-danger'>ID de usuario no válido.</div>";
    exit;
}

$id_usuario = $_GET['id'];

try {
    // Obtener datos del usuario actual
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
    $stmt->execute([$id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "<div class='container mt-5 alert alert-warning'>Usuario no encontrado.</div>";
        exit;
    }

    // Obtener personas
    $stmtPersonas = $conn->query("SELECT id_persona, nombre, apellido FROM personas");
    $personas = $stmtPersonas->fetchAll(PDO::FETCH_ASSOC);

    // Obtener roles
    $stmtRoles = $conn->query("SELECT id_rol, nombre FROM roles");
    $roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "<div class='container mt-5 alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    exit;
}
?>

<div class="container mt-5 d-flex justify-content-center flex-column">
    <h2 class="mb-4 text-center">Editar Usuario</h2>

    <form action="procesar_editar.php" method="POST" style="width: 70%; margin: auto;" class="border p-4 rounded">
        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($usuario['id_usuario']) ?>">

        <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="text" name="username" id="username" class="form-control" required
                   value="<?= htmlspecialchars($usuario['username']) ?>">
        </div>

        <div class="mb-3">
            <label for="id_persona" class="form-label">Persona</label>
            <select name="id_persona" id="id_persona" class="form-select" required>
                <option value="">Seleccione</option>
                <?php foreach ($personas as $p): ?>
                    <option value="<?= $p['id_persona'] ?>" <?= $usuario['id_persona'] == $p['id_persona'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['nombre'] . ' ' . $p['apellido']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="id_rol" class="form-label">Rol</label>
            <select name="id_rol" id="id_rol" class="form-select" required>
                <option value="">Seleccione</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= $r['id_rol'] ?>" <?= $usuario['id_rol'] == $r['id_rol'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($r['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
            <input type="password" name="password" id="password" class="form-control">
            <div class="form-text">Dejar vacío si no se desea cambiar.</div>
        </div>

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
    </form>
</div>

<?php include('../plantilla/footer.php'); ?>
