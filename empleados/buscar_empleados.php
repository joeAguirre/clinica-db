

<?php

    include_once('../conexion.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>


<div class="container mt-5">
    <div class="row">
        <div class="col-8 mx-auto">
            <h2 class="mb-4">Buscar empleados</h2>
            <form method="POST">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="busqueda" placeholder="Buscar por nombre o apellido" required>
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </form>
        </div>
    </div>
    
</div>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['busqueda'])) {
       

       $busqueda = trim($_POST['busqueda']);
       $busqueda_param = "%" . $busqueda . "%";

       try {
           $sql = "SELECT empleados.empleado_id, personas.nombre, personas.apellido
            FROM empleados
            INNER JOIN personas ON empleados.id_persona = personas.id_persona
            WHERE personas.nombre LIKE :busqueda 
            OR personas.apellido LIKE :busqueda
            OR CONCAT(personas.nombre, ' ', personas.apellido) LIKE :busqueda";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':busqueda', $busqueda_param);
            $stmt->execute();

             $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
       } catch (\Throwable $e) {
            echo "Eror al ejecutar busqueda" . $e->getMessage();
       }
}

  // si existe algun registro de empleados 


 if (isset($empleados)): ?>
    <div class="container mt-4">
            <div class="row">
                <div class="col-9 mx-auto">
                    <h4>Resultados:</h4>
            <?php if (count($empleados) > 0): ?>
                <ul class="list-group">
                    <?php foreach ($empleados as $empleado): ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($empleado['nombre'] . ' ' . $empleado['apellido']); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No se encontraron empleados.</p>
            <?php endif; ?>
            </div>
        </div>
        
    </div>
<?php endif;
?>



<?php
   include('../plantilla/footer.php');
?>