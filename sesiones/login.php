<?php
session_start();
include '../conexion.php';
include '../plantilla/header.php';

$check = $conn->query("SELECT COUNT(*) as total FROM usuarios");
$total = $check->fetch(PDO::FETCH_ASSOC)['total'];

if ($total == 0) {
    // Redirigimos a registro_unico.php si no hay usuarios
    header("Location: registro_unico.php");
    exit;
}
?>

<div class="container mt-5 d-flex justify-content-center flex-column">
    <?php if (isset($_SESSION['mensaje'])): ?>
        <div id="mensaje-anuncio" class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
                unset($_SESSION['tipo_mensaje']);
            ?>
        </div>
    <?php endif; ?>

    <h2 class="mb-4 text-center">Iniciar Sesión</h2>

    <form action="procesar_login.php" method="POST" class="needs-validation border p-4 rounded" 
    style="width: 40%; margin: auto; background-color: #0799b6;" novalidate>
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="text" name="username" id="username" class="form-control" required>
            <div class="invalid-feedback">Por favor ingrese su nombre de usuario.</div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
            <div class="invalid-feedback">Por favor ingrese su contraseña.</div>
        </div>

        <button type="submit" class="btn btn-primary">Ingresar</button>
    </form>
</div>

<script>
    setTimeout(function() {
        const mensaje = document.getElementById('mensaje-anuncio');
        if (mensaje) {
            mensaje.style.display = 'none';
        }
    }, 3000);
</script>

<?php include '../plantilla/footer.php'; ?>
