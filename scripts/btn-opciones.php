<?php 
   function seccionDerecha($titulo, $agregar, $buscar) {   ?>

        <div class="titulo">
        <h2><?php echo $titulo; ?></h2>
        </div>
        <div class="seccion-derecha">
        <div class="grupo-opciones">
            <div class="opciones">
                <i class="fa-solid fa-file-circle-plus"></i><br>
                <a href="./pacientes/agregar_paciente.php">
                    <?php echo $agregar; ?>
                </a>
            </div>
            <div class="opciones">
                <i class="fa-solid fa-magnifying-glass"></i><br>
                <span><?php echo $buscar; ?></span>
            </div>
        </div>
        </div>

<?php   }          ?>



