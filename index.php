<?php include_once('./inicio/cabecera.php');   ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == "GET") {
        $page = isset($_GET['page']) ? $_GET['page'] : "inicio";

        switch ($page) {
            case 'inicio':
                include_once('./inicio/inicio.php');
                break;
            
            case 'pacientes':
                include_once('./inicio/pacientes.php');
                break;

            case 'medicos':
                include_once('./inicio/medicos.php');
                break;

            case 'empleados':
                include_once('./inicio/empleados.php');
                break;
                
            default:
                echo "No se encontro la pagina solicitada";
                break;
        }
    }
    
?>

<?php include_once('./inicio/pie.php'); ?>