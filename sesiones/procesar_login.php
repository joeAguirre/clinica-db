<?php
session_start();
include '../conexion.php';
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $raw_password = trim($_POST['password']);

    try {
        $sql = "SELECT u.id_usuario, u.username, u.id_rol, AES_DECRYPT(u.password, ?) AS password_real, r.nombre AS rol_nombre
                FROM usuarios u
                JOIN roles r ON u.id_rol = r.id_rol
                WHERE u.username = ?
";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$AES_KEY, $username]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && $usuario['password_real'] === $raw_password) {
            // guardar en sesion el usuario
            if ($usuario && $usuario['password_real'] === $raw_password) {
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['username'] = $usuario['username'];
                $_SESSION['rol'] = $usuario['rol_nombre']; 
            }

            //Mensaje
            header('Location: ../index.php');
            exit;
        } else {
            $_SESSION['mensaje'] = 'Nombre de usuario o contraseña incorrectos.';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: login.php');
            exit;
        }
    } catch (Exception $e) {
        echo "Error al iniciar sesión: " . $e->getMessage();
    }
}
?>
