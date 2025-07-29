<?php

include_once('../conexion.php');
include_once('../sesiones/verificar_acesso.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
<?php if (isset($_SESSION['mensaje'])): ?>
        <div id="mensaje-anuncio" class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
            ?>
        </div>
    <?php endif; ?>
    <a href="../index.php?page=usuarios" class="btn btn-danger m-2"> 
        Volver
    </a>
    <div class="row">
        <div class="col-8 mx-auto">
            <h2 class="mb-4">Buscar usuarios</h2>
            <form method="POST">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="busqueda" placeholder="Buscar por nombre de usuario" required>
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$usuarios = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['busqueda'])) {
    $busqueda = trim($_POST['busqueda']);
    $busqueda_param = "%" . $busqueda . "%";

    try {
        $sql = "SELECT u.id_usuario, u.username, r.nombre AS rol
                FROM usuarios u
                INNER JOIN roles r ON u.id_rol = r.id_rol
                WHERE u.username LIKE :busqueda";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':busqueda', $busqueda_param);
        $stmt->execute();

        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
        echo "<div class='alert alert-danger'>Error al buscar usuarios: " . $e->getMessage() . "</div>";
    }
}
?>

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-9 mx-auto">
            <h4>Resultados:</h4>
            <?php if (count($usuarios) > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['username']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                            <td>
                                <!-- Acciones opcionales -->
                                <a href="editar_usuario.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="eliminar_usuario.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que quieres eliminar este usuario?');">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No se encontraron usuarios.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>

<script>

        setTimeout(function() {
            const mensaje = document.getElementById('mensaje-anuncio');
            if (mensaje) {
                mensaje.style.display = 'none';
            }
        },  3000); 
    </script>

<?php include('../plantilla/footer.php'); ?>
