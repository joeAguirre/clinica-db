<?php
include_once('../sesiones/verificar_acesso.php');
include '../conexion.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_usuario = intval($_GET['id']);

    try {
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);

        $_SESSION['mensaje'] = "Usuario eliminado correctamente.";
        $_SESSION['tipo_mensaje'] = "success";
    } catch (Exception $e) {
        $_SESSION['mensaje'] = "Error al eliminar el usuario: " . $e->getMessage();
        $_SESSION['tipo_mensaje'] = "danger";
    }
} else {
    $_SESSION['mensaje'] = "ID de usuario inválido.";
    $_SESSION['tipo_mensaje'] = "danger";
}

header('Location: buscar_usuario.php');
exit;
?>
