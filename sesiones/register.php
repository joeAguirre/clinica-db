<?php
session_start();
include '../conexion.php';
include '../plantilla/header.php';

try {
    // Obtener personas como array asociativo
    $stmtPersonas = $conn->query("SELECT id_persona, nombre, apellido FROM personas");
    $personas = $stmtPersonas->fetchAll(PDO::FETCH_ASSOC);

    // Obtener roles
    $stmtRoles = $conn->query("SELECT id_rol, nombre FROM roles");
    $roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error al obtener datos: " . $e->getMessage();
    exit;
}
?>

<div class="container mt-5 d-flex justify-content-center flex-column">
<?php if (isset($_SESSION['mensaje'])): ?>
        <div id="mensaje-anuncio"  class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
            ?>
        </div>
    <?php endif; ?>
    <h2 class="mb-4">Registro de Usuario</h2>

    <form action="procesar_register.php" method="POST" class="needs-validation border p-4 rounded" novalidate>
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="text" name="username" id="username" class="form-control" required />
            <div class="invalid-feedback">Por favor ingrese un nombre de usuario.</div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required />
            <div class="invalid-feedback">Por favor ingrese una contraseña.</div>
        </div>

        <div class="mb-3">
            <label for="id_persona" class="form-label">Persona</label>
            <select name="id_persona" id="id_persona" class="form-select" required>
                <option value="" selected>Seleccione</option>
                <?php foreach ($personas as $p): ?>
                    <option value="<?= htmlspecialchars($p['id_persona']) ?>">
                        <?= htmlspecialchars($p['nombre'] . ' ' . $p['apellido']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Por favor seleccione una persona.</div>
        </div>

        <div class="mb-3">
            <label for="id_rol" class="form-label">Rol</label>
            <select name="id_rol" id="id_rol" class="form-select" required>
                <option value="" selected>Seleccione</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?= htmlspecialchars($r['id_rol']) ?>">
                        <?= htmlspecialchars($r['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Por favor seleccione un rol.</div>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>

</div>  


    <script>

        setTimeout(function() {
            const mensaje = document.getElementById('mensaje-anuncio');
            if (mensaje) {
                mensaje.style.display = 'none';
            }
        },  3000); 
    </script>
<?php
    include('../plantilla/footer.php');

?>

