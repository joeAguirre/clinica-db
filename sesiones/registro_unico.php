<?php
session_start();
include '../conexion.php';
include '../config.php';

// Verificar si hay usuarios registrados
$stmt = $conn->query("SELECT COUNT(*) AS total FROM usuarios");
$total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];


if ($total > 0) {
    $_SESSION['mensaje'] = "El registro único ya fue realizado. Contacte al administrador.";
    $_SESSION['tipo_mensaje'] = "danger";

    //echo "Registro ya realizado";   
    header('Location: login.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $raw_password = trim($_POST['password']);
    $id_rol_admin = 1; 

    if (empty($username) || empty($raw_password)) {
        $error = "Debe completar todos los campos.";
    } else {
        try {
            // Verificar que username no exista
            $check = $conn->prepare("SELECT id_usuario FROM usuarios WHERE username = ?");
            $check->execute([$username]);
            if ($check->fetch()) {
                $error = "El nombre de usuario ya existe.";
            } else {
                // Insertar usuario admin sin persona asociada 
                $sql = "INSERT INTO usuarios (username, password, id_persona, id_rol) 
                        VALUES (?, AES_ENCRYPT(?, ?), NULL, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$username, $raw_password, $AES_KEY, $id_rol_admin]);

                $_SESSION['mensaje'] = "Usuario administrador registrado correctamente.";
                $_SESSION['tipo_mensaje'] = "success";
                header('Location: register.php');
                exit;
            }
        } catch (Exception $e) {
            $error = "Error al registrar usuario: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro único - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Registro único de administrador</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="mt-4 mx-auto p-4 rounded" style="max-width: 500px; background-color: #0799b6;">
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="text" name="username" id="username" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Administrador</button>
    </form>
</div>
</body>
</html>
