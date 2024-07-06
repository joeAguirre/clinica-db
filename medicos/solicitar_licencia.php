<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Licencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .formulario-licencia {
            max-width: 700px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container formulario-licencia">
        <h2 class="text-center">Solicitar Licencia para Médico</h2>
        <form action="procesar_licencia.php" method="post">
            <input type="hidden" name="codigo_medico" value="<?php echo htmlspecialchars($_GET['codigo_medico']); ?>">
            <div class="mb-3">
                <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="mb-3">
                <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
            </div>
            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo</label>
                <textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Solicitar Licencia</button>
                <a href="index.php" class="btn btn-secondary">Volver al Inicio</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
