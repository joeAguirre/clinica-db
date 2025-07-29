<?php   
     include('./funciones/btn-opciones.php');

    $titulo = "Administrar Usuarios";

    $agregar = "Agregar Usuarios";

    $buscar = "Buscar Usuarios";

    $url_agregar = "/sesiones/register.php";

    $url_buscar = "/sesiones/buscar_usuario.php";

    seccionDerecha($titulo, $agregar, $buscar, $url_agregar, $url_buscar);

?>