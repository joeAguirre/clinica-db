<?php
     include_once('../conexion.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="formulario-paciente">
    <h2 class="title">Agregar Paciente</h2>
    <form action="./agregar_paciente.php" method="post">
        <div class="nombre">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre">
        </div>
        <div class="apellido">
            <label for="apellido">Apellido</label>
            <input type="text" name="apellido" id="apellido">
        </div>
        <div class="fecha_nacimiento">
            <label for="fecha_nacimiento">Fecha de nacimiento</label>
            <input type="text" name="fecha_nacimiento" id="fecha_nacimiento">
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
        <?php  
              $sql = "SELECT * FROM municipio";
              $stmt = $conn->prepare($sql);

              if($stmt->execute()) {
                  $resultados = $stmt->fetchAll();
              ?>
        <div>
            <label>Municipio</label>
            <select name="municipio">
               <?php   foreach ($resultados as $resultado) {  ?>
                   <option value="<?php echo $resultado['id_municipio'] ?>"><?php echo $resultado['nombre'];  ?></option>
             <?php     }
              } else {
                 echo "No se encontraron los municipios";
              }
           ?>

            </select>
          </div>
        <div>
            <label>Departamentos</label>
            <select name="obras">Obras</select>
        </div>
        <div>
            <label>Provincias</label>
            <select name="obras">Obras</select>
        </div>
        <div>
            <label>Pais</label>
            <select name="obras">Obras</select>
        </div>
        <div>
            <label>Obra Social</label>
            <select name="obras">Obras</select>
        </div>
        <div>
            <label>Tipo de sangre</label>
            <select name="tipo_sangre">
                <option value="0">0+</option>
            </select>
        </div>
        <button type="submit">Guardar</button>
    </form>
    </div>
    
</body>
</html>