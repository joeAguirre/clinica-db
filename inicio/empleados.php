<?php   
     include('./funciones/btn-opciones.php');

    $titulo = "Administrar Empleados";

    $agregar = "Agregar Empleados";

    $buscar = "Buscar Empleados";

    $url_agregar = "/empleados/carga-empleados.php";

    $url_buscar = "/empleados/buscar_empleados.php";

    seccionDerecha($titulo, $agregar, $buscar, $url_agregar, $url_buscar);

?>