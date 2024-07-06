<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Definir Disponibilidad de Médicos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .formulario-disponibilidad {
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
    <div class="container formulario-disponibilidad">
        <h2 class="text-center">Definir Disponibilidad de Médicos</h2>
        <form action="guardar_disponibilidad.php" method="post">
            <div class="mb-3">
                <label for="codigo_medico" class="form-label">Código Médico</label>
                <input type="text" class="form-control" id="codigo_medico" name="codigo_medico" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Días de la Semana</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="lunes" name="dia_semana[]" value="Lunes">
                    <label class="form-check-label" for="lunes">Lunes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="martes" name="dia_semana[]" value="Martes">
                    <label class="form-check-label" for="martes">Martes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="miercoles" name="dia_semana[]" value="Miércoles">
                    <label class="form-check-label" for="miercoles">Miércoles</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="jueves" name="dia_semana[]" value="Jueves">
                    <label class="form-check-label" for="jueves">Jueves</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="viernes" name="dia_semana[]" value="Viernes">
                    <label class="form-check-label" for="viernes">Viernes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="sabado" name="dia_semana[]" value="Sábado">
                    <label class="form-check-label" for="sabado">Sábado</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="domingo" name="dia_semana[]" value="Domingo">
                    <label class="form-check-label" for="domingo">Domingo</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
            </div>
            <div class="mb-3">
                <label for="hora_fin" class="form-label">Hora de Fin</label>
                <input type="time" class="form-control" id="hora_fin" name="hora_fin" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="../index.php" class="btn btn-secondary">Volver al Inicio</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
