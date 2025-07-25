<?php
require_once '../../conexion.php';

require_once('../../plantilla/header.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de análisis no válido.");
}

$id = $_GET['id'];

try {
    $stmt = $conn->prepare("SELECT * FROM analisis_clinico WHERE id_analisis = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $analisis = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$analisis) {
        die("Análisis clínico no encontrado.");
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!-- HTML + Bootstrap 5 -->

<body class="container mt-5">
    <h3>Editar Análisis Clínico</h3>
    <form action="actualizar_analisis.php" method="POST">
        <input type="hidden" name="id_analisis" value="<?php echo $analisis['id_analisis']; ?>">
        <input type="hidden" name="id_paciente" value="<?php echo $analisis['id_paciente']; ?>">

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de análisis</label>
            <input type="text" name="tipo" class="form-control" 
                   value="<?php echo htmlspecialchars($analisis['tipo']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control"><?php echo htmlspecialchars($analisis['descripcion']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="resultado" class="form-label">Resultado</label>
            <textarea name="resultado" class="form-control"><?php echo htmlspecialchars($analisis['resultado']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" 
                   value="<?php echo htmlspecialchars($analisis['fecha']); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <a href="ver_analisis.php?id_paciente=<?php echo $analisis['id_paciente']; ?>" class="btn btn-secondary">Cancelar</a>
    </form>

    <?php
         require_once('../../plantilla/footer.php');
    ?>
