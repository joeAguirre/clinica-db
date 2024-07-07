<?php
    session_start();
   
    $especialidades = [
        'cardiologia', 
        'dermatologia', 
        'neurologia', 
        'pediatria', 
        'oftalmologia', 
        'ginecologia', 
        'psiquiatria', 
        'endocrinologia', 
        'traumatologia', 
        'oncologia'
    ];
    
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
    <?php
        if (isset($_SESSION['mensaje'])) {
            echo '<p class="msg">' . htmlspecialchars($_SESSION['mensaje']) . '</p>';
            unset($_SESSION['mensaje']);
        }
    
    ?>
    <div class="container formulario-medico">
        <h2 class="text-center">Agregar Médico</h2>
        <form action="./guardar_medicos.php" method="post">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-z\s]+">
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required pattern="[A-Za-z\s]+">
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="especialidad" class="form-label">Especialidad</label>
                <?php 
                echo "<select class='form-select' name='especialidad' id='especialidad'>";
                foreach ($especialidades as $especialidad) {
                    echo "<option value='$especialidad'>$especialidad</option>";
                } 
                echo "</select>";
                ?>
            </div>
            <div class="mb-3">
                <label for="codigo_medico" class="form-label">Codigo Medico</label>
                <input type="text" class="form-control" id="codigo_medico" name="codigo_medico" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="../index.php" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
