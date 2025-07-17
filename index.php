<?php
    define('BASE_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/programacion/clinica-db-2/');
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . '/clinica2/');

    include("./plantilla/header.php");

?>
    
    <div class="navbar">
        <div class="logo">
           <i class="fa-solid fa-house-chimney-medical logo-principal"></i>
            <span>Mi Clinica</span>
        </div>

        <nav>
            <a href="index.php?page=inicio">
               <i class="fa-solid fa-house logo-nav"></i>
                Inicio
            </a>
            <a href="index.php?page=pacientes">
               <i class="fa-solid fa-person-circle-plus logo-nav"></i>
                Pacientes
            </a>

             <a href="index.php?page=medicos">
                <i class="fa-solid fa-user-doctor logo-nav"></i>
                Medicos
            </a>
            <a href="index.php?page=empleados">
                <i class="fa-solid fa-user-tie logo-nav"></i>
                Empleados
            </a>
        </nav>
    </div>
    
    <div class="contenido">

<?php
    

    if($_SERVER['REQUEST_METHOD'] == "GET") {
        $page = isset($_GET['page']) ? $_GET['page'] : "inicio";

        switch ($page) {
            case 'inicio':
                include_once('./inicio/inicio.php');
                break;
            
            case 'pacientes':
                include('./inicio/pacientes.php');
                break;

            case 'medicos':
                include('./inicio/medicos.php');
                break;

            case 'empleados':
                include('./inicio/empleados.php');
                break;
                
            default:
                echo "No se encontro la pagina solicitada";
                break;
        }
    }
    
?>

     </div>

    <?php
        include("./plantilla/footer.php");
    ?>
</body>
</html>