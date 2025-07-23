<?php
session_start();
include '../conexion.php';  
include '../config.php';   

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $raw_password = trim($_POST['password']);
    $id_persona = intval($_POST['id_persona']);
    $id_rol = intval($_POST['id_rol']);

    try {
         $check = $conn->prepare("SELECT id_usuario FROM usuarios WHERE username = ?");
        $check->execute([$username]);
        if ($check->fetch()) {
            $_SESSION['mensaje'] = "El nombre de usuario ya existe.";
            $_SESSION['tipo_mensaje'] = "danger";
            header("Location: register.php");
            exit;
        }

        
        $sql = "INSERT INTO usuarios (username, password, id_persona, id_rol) 
                VALUES (?, AES_ENCRYPT(?, ?), ?, ?)";
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute([$username, $raw_password, $AES_KEY, $id_persona, $id_rol]);

        if ($success) {
            $_SESSION['mensaje'] = "Usuario registrado correctamente.";
            $_SESSION['tipo_mensaje'] = "success";
            header("Location: login.php");
            exit;
        }
    } catch (\Throwable $th) {
        echo "Error al registrar el usuario: " . $th->getMessage();
    }
    

   
}
?>
