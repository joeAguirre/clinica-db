<?php
   session_start();
   include_once('../sesiones/verificar_acesso.php');

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

   include_once("../plantilla/header.php");
?>

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

   <?php
        include_once("../plantilla/footer.php");
   ?>
