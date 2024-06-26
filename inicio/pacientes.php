
<?php   
     include('./scripts/btn-opciones.php');

    $titulo = "Administrar Pacientes";

    $agregar = "Agregar Pacientes";

    $buscar = "Buscar Pacientes";

    $url_agregar = "pacientes/formulario-carga.php";

    $url_buscar = "pacientes/buscar_pacientes.php";

    seccionDerecha($titulo, $agregar, $buscar, $url_agregar, $url_buscar);

?>