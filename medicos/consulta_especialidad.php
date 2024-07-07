<?php
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
    <title>Buscar Médicos por Especialidad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
   <div class='container px-5'>
         <h2 class='mt-4 text-center'>Buscar Médicos por Especialidad</h2>
         <form action="./especialidad_pdf.php" method="post">
            <div class="mb-3">
              <label for="especialidad" class="form-label">Selecciona una especialidad:</label>
              <?php 
              echo "<select class='form-select' name='especialidad' id='especialidad'>";
              foreach ($especialidades as $especialidad) {
                  echo "<option value='$especialidad'>$especialidad</option>";
              } 
              echo "</select>";
              ?>
            </div>
            <button type="submit" class="btn btn-primary">Generar Informe</button>
            <a href="../index.php" class="btn btn-secondary">Volver al Inicio</a>
         </form>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
