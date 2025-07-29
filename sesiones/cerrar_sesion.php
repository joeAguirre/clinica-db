<?php
     include_once('../sesiones/verificar_acesso.php');
    // Inicia la sesión
    session_start();

    // Destruye todas las variables de sesión
    session_unset();

    // Destruye la sesión
    session_destroy();

    header('Location: login.php');
exit;

?>
