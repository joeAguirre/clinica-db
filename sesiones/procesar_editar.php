<?php
include_once('../sesiones/verificar_acesso.php');
include '../conexion.php';  
include '../config.php';   

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = intval($_POST['id_usuario']);
    $username = trim($_POST['username']);
    $raw_password = trim($_POST['password']);
    $id_persona = intval($_POST['id_persona']);
    $id_rol = intval($_POST['id_rol']);

    try {
        // Verificar si el nuevo username ya está en uso por otro usuario
        $check = $conn->prepare("SELECT id_usuario FROM usuarios WHERE username = ? AND id_usuario != ?");
        $check->execute([$username, $id_usuario]);
        if ($check->fetch()) {
            $_SESSION['mensaje'] = "El nombre de usuario ya está en uso por otro usuario.";
            $_SESSION['tipo_mensaje'] = "danger";
            header("Location: editar_usuario.php?id=$id_usuario");
            exit;
        }

        // Si se proporcionó una nueva contraseña
        if (!empty($raw_password)) {
            $sql = "UPDATE usuarios 
                    SET username = ?, password = AES_ENCRYPT(?, ?), id_persona = ?, id_rol = ?
                    WHERE id_usuario = ?";
            $stmt = $conn->prepare($sql);
            $success = $stmt->execute([$username, $raw_password, $AES_KEY, $id_persona, $id_rol, $id_usuario]);
        } else {
            // Si no se cambió la contraseña
            $sql = "UPDATE usuarios 
                    SET username = ?, id_persona = ?, id_rol = ?
                    WHERE id_usuario = ?";
            $stmt = $conn->prepare($sql);
            $success = $stmt->execute([$username, $id_persona, $id_rol, $id_usuario]);
        }

        if ($success) {
            $_SESSION['mensaje'] = "Usuario actualizado correctamente.";
            $_SESSION['tipo_mensaje'] = "success";
            header("Location: buscar_usuario.php"); // Ajustá esta ruta si tenés otra lista de usuarios
            exit;
        }

    } catch (\Throwable $th) {
        echo "Error al editar el usuario: " . $th->getMessage();
    }
} else {
    $_SESSION['mensaje'] = "No se recibieron datos del formulario.";
    $_SESSION['tipo_mensaje'] = "danger";
    header("Location: buscar_usuario.php");
    exit;
}
?>
