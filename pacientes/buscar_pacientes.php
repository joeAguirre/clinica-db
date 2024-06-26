<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busqueda en la Clínica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .search-bar {
            width: 60%;
        }
        .search-box {
            background-color: #0d6efd;
            padding: 20px;
            border-radius: 8px;
        }
        .search-box h2 {
            color: #fff;
        }
        .result-list {
            margin-top: 20px;
        }
    </style>
</head>
<body>
  <div class="container search-container">
        <div class="search-bar search-box text-center">
            <h2 class="mb-5">Buscar Pacientes</h2>
            <form method="POST" class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" name="numero_afiliado">
                <button class="btn btn-outline-light" type="submit">Buscar</button>
            </form>
        </div>


        <?php

         include(__DIR__ . "/../conexion.php");

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['numero_afiliado'])) {
            $numero_afiliado = $_POST['numero_afiliado'];

            try {
                // Preparar consulta SQL con parámetros nombrados
                $stmt = $conn->prepare("
                    SELECT nombre, apellido, pacientes.numero_afiliado
                    FROM personas
                    JOIN pacientes ON personas.id_persona = pacientes.id_persona
                    WHERE pacientes.numero_afiliado = :numero_afiliado
                ");

                // Vincular parámetros
                $stmt->bindParam(':numero_afiliado', $numero_afiliado, PDO::PARAM_STR);

                // Ejecutar consulta
                $exec = $stmt->execute();

                echo "<div class='result-list'>";
                echo "<h3>Resultados de búsqueda para número de afiliado: " . htmlspecialchars($numero_afiliado) . "</h3>";

                
                if ($stmt->rowCount() > 0) {
                    echo "<ul class='list-group'>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li class='list-group-item'>Nombre: " . htmlspecialchars($row['nombre']) . " " . htmlspecialchars($row['apellido']) . " - Número de afiliado: " . htmlspecialchars($row['numero_afiliado']) . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No se encontraron resultados</p>";
                }
                echo "</div>";

            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

            // Cerrar conexión
            $pdo = null;
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
