<?php
    session_start();
    define('BASE_URL', '/programacion/clinica-db');

    if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['username'])) {
        // Si no hay usuario logueado, redirigir al login
        header('Location: ' . BASE_URL . '/sesiones/login.php');
        exit;
    }

    if(isset($_SESSION['rol'])){
        if($_SESSION['rol'] === "paciente"){
            header("Location: " . BASE_URL . '/pacientes/buscar_pacientes.php');
            exit;
        }
    }

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Clinica Medica</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/estilos.css">
    </head>
    <body>
    
    <div class="navbar">
        <div class="logo">
           <i class="fa-solid fa-house-chimney-medical logo-principal"></i>
            <span>Mi Clinica</span>
        </div>

        <nav>
            <?php if ($_SESSION['rol'] === 'admin'): ?>
                <a href="index.php?page=inicio">
                <i class="fa-solid fa-house logo-nav"></i>
                    Inicio
                </a>
            <?php endif; ?>
            <?php if ($_SESSION['rol'] === 'admin' || $_SESSION['rol'] === 'medico'): ?>
                <a href="index.php?page=pacientes">
                <i class="fa-solid fa-person-circle-plus logo-nav"></i>
                    Pacientes
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['rol'] === 'admin'): ?>
                <a href="index.php?page=medicos">
                    <i class="fa-solid fa-user-doctor logo-nav"></i>
                    Medicos
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['rol'] === 'admin'): ?>
                <a href="index.php?page=empleados">
                    <i class="fa-solid fa-user-tie logo-nav"></i>
                    Empleados
                </a>
            <?php endif; ?>
        </nav>
    </div>
    
    <div class="contenido">
        

<?php

    if($_SERVER['REQUEST_METHOD'] == "GET") {
        $page = isset($_GET['page']) ? $_GET['page'] : "inicio";

        switch ($page) {
            case 'inicio':
                if ($_SESSION['rol'] === 'admin'):
                  include_once('./inicio/inicio.php');
                endif;
                break;
            
            case 'pacientes':
                include('./inicio/pacientes.php');
                break;

            case 'medicos':
                if ($_SESSION['rol'] === 'admin'):
                   include('./inicio/medicos.php');
                endif; 
                break;

            case 'empleados':
                if ($_SESSION['rol'] === 'admin'):
                   include('./inicio/empleados.php');
                endif; 
                break;
                
            default:
                echo "No se encontro la pagina solicitada";
                break;
        }
    }
    
?>

     </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>