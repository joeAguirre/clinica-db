<?php
     session_start();

     include_once('../conexion.php');
?>

<?php
     if (isset($_SESSION['mensaje'])) {
        echo '<p class="msg">' . htmlspecialchars($_SESSION['mensaje']) . '</p>';
        
        unset($_SESSION['mensaje']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Pacientes</title>
    <link rel="stylesheet" href="../css/pacientes.css">
</head>
<body>
    <div class="formulario-paciente">
    <h2 class="title">Agregar Paciente</h2>
    <form action="./agregar_paciente.php" method="post">
        <div class="nombre">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required pattern="[A-Za-z\s]+">
        </div>
        <div class="apellido">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido" required pattern="[A-Za-z\s]+">
        </div>
        <div class="fecha_nacimiento">
            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>
        </div>
        <div class="direccion">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion">
        </div>
        <div class="telefono">
            <label for="telefono">Telefono</label>
            <input type="text" name="telefono" id="telefono">
        </div>
        <div class="email">
            <label for="email">Email</label>
            <input type="email" name="email" id="email">
        </div>
        <div class="municipio">
            <label for="email">Municipio</label>
            <input type="text" name="municipio" id="municipio">
        </div>

        <div class="departamento">
            <label for="email">Departamento</label>
            <input type="text" name="departamento" id="departamento">
        </div>
          
        <div>
            <label for="provincias">Provincias</label>
            <input type="text" name="provincias" id="provincias">
        </div>
        <div>
            <label for="pais">Pais</label>
            <input type="text" name="pais" id="pais">
        </div>
        <div class="obra_social">
            <label>Obra Social</label>
            <?php
                     include_once('../conexion.php');

                        $sql = "SELECT * FROM obra_social";
                        $stmt = $conn->prepare($sql);

                        if($stmt->execute()) {
                           $resultados = $stmt->fetchAll(); 

                          if ($resultados) {  ?>
                          
                   <select name="obra_social">
                        <?php    foreach ($resultados as $resultado) {    ?>
                           <option value="<?php echo $resultado['id_obra_social'] ?>"><?php echo $resultado['nombre']; ?></option>
                        <?php    }     ?>
                    </select>
                         
                        <?php } else {
                               echo "No se encontraron los resultados";
                           }
                           
                        } else {
                            echo "Error al ejecutar la consulta";
                        }
                     
                ?>
        </div>
        <div>
            <label for="num_afiliado">Numero de Afiliado</label>
            <input type="text"  pattern="\d*" name="num_afiliado" id="num_afiliado">
        </div>
        <div>
            <label>Tipo de sangre</label>
            <?php
                    include_once('../conexion.php');

                    $sql = "SELECT * FROM tipo_sangre";
                    $stmt = $conn->prepare($sql);

                    if($stmt->execute()) {
                        $resultados = $stmt->fetchAll(); 

                        if ($resultados) {  ?>
                        
                <select name="tipo_sangre">
                    <?php    foreach ($resultados as $resultado) {    ?>
                        <option value="<?php echo $resultado['id_tipo_sangre'] ?>"><?php echo $resultado['nombre']; ?></option>
                    <?php    }     ?>
                </select>
                        
                    <?php } else {
                            echo "No se encontraron los resultados";
                        }
                        
                    } else {
                        echo "Error al ejecutar la consulta";
                    }
                     
                ?>
        </div>
        <div class="botones">
            <button class="guardar" type="submit">Guardar</button>
            <button type="button">
            <a href="../index.php">Volver </a>
            </button>
            
        </div>
        
    </form>
    </div>
    
</body>
</html>