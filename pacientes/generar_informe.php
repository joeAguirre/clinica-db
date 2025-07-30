<?php
    

    include_once('../sesiones/verificar_acesso.php');

    include_once('../plantilla/header.php');

?>

<body>
    <div class="container mt-5">
        <h2>Generar Informe de Citas Médicas</h2>
        <form action="consulta_informe.php" method="post">
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
            </div>
            <button type="submit" class="btn btn-primary">Generar Informe</button>
        </form>
    </div>

<?php
     include('../plantilla/footer.php');


?>