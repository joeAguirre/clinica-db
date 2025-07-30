<?php
    
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include_once('../sesiones/verificar_acesso.php');

    include_once('../conexion.php');
   

    $sql = "SELECT id_especialidad, nombre FROM especialidades";

    $stmt = $conn->query($sql);

    $especialidades = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .formulario-medico {
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
            background-color: #9cd2d3;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .msg {
            background-color: green; 
            color: white; 
            padding: 10px 15px; 
            border: 1px solid #c3e6cb; 
            border-radius: 5px; 
            text-align: center; 
            margin: 20px auto; 
            max-width: 400px; 
         }
    </style>
</head>
<body>
      <?php if (isset($_SESSION['mensaje'])): ?>
        <div id="mensaje-anuncio" class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?>">
            <?php 
                echo $_SESSION['mensaje']; 
                unset($_SESSION['mensaje']);
            ?>
        </div>
    <?php endif; ?>
    <div class="container formulario-medico">
        <h2 class="text-center">Agregar Médico</h2>
        <form action="./guardar_medicos.php" method="post">
            <div class="row">
                 <div class="mb-3 col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-z\s]+">
            </div>
            <div class="mb-3 col-md-6">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required pattern="[A-Za-z\s]+">
            </div>
            </div>
           
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="direccion" name="direccion">
                </div>
                
                <div class="mb-3 col-md-6">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono">
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="especialidad" class="form-label">Especialidad</label>
                <?php 
                   echo '<select class="form-select" id="especialidad" name="especialidad">';

                  if (isset($especialidades) && count($especialidades) > 0) {
                    foreach ($especialidades as $especialidad) {
                      echo '<option value="' . ($especialidad['id_especialidad']) . '">';
                      echo htmlspecialchars($especialidad['nombre']);
                      echo '</option>';
                      
                        
                    }
                    
                  } else {
                    echo '  <option value="">No hay especialidades disponibles</option>';
                  }

                  echo '</select>';

                
                  
                ?>
            </div>
            <div class="mb-3">
                <label for="codigo_medico" class="form-label">Codigo Medico</label>
                <input type="text" class="form-control" id="codigo_medico" name="codigo_medico" required>
            </div>
             <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value=1>Activo</option>
                    <option value=0>Inactivo</option>
                </select>
            </div> 
            
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="pais" class="form-label">País</label>
                    <input type="text" class="form-control" id="pais" name="pais">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="provincia" class="form-label">Provincia</label>
                    <input type="text" class="form-control" id="provincia" name="provincia">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="departamento" class="form-label">Departamento</label>
                    <input type="text" class="form-control" id="departamento" name="departamento">
                </div>
                <div class="mb-3 col-md-6">
                    <label for="municipio" class="form-label">Municipio</label>
                    <input type="text" class="form-control" id="municipio" name="municipio">
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="../index.php" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>

    <script>

        setTimeout(function() {
            const mensaje = document.getElementById('mensaje-anuncio');
            if (mensaje) {
                mensaje.style.display = 'none';
            }
        },  3000); 
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
