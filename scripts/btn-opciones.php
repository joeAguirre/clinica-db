<?php 


   function seccionDerecha($titulo, $agregar, $buscar, $url_agregar="#", $url_buscar="#") {   ?>

        <div class="titulo">
        <h2><?php echo $titulo; ?></h2>
        </div>
        <div class="seccion-derecha">
        <div class="grupo-opciones">
            <div class="opciones">
                <i class="fa-solid fa-file-circle-plus"></i><br>
                <a href="<?php echo BASE_URL . $url_agregar; ?>">
                    <?php echo $agregar; ?>
                </a>
            </div>
            <div class="opciones">
                <i class="fa-solid fa-magnifying-glass"></i><br>
                <a href="<?php echo BASE_URL . $url_buscar ?>">
                    <?php echo $buscar; ?>
                </a>
            </div>
        </div>
        </div>

<?php   }          ?>



