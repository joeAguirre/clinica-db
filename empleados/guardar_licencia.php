<?php
include_once('../sesiones/verificar_acesso.php');
include_once('../conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['empleado_id'])) {
    $empleado_id = intval($_POST['empleado_id']);
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $motivo = trim($_POST['motivo']);
     $id_empleado_sustituto = isset($_POST['empleado_sustituto']) ? intval($_POST['empleado_sustituto']) : null;

    try {
        //iniciar transaccion
        $conn->beginTransaction(); 

        $sql = "INSERT INTO licencias (id_empleado, fecha_inicio, fecha_fin, motivo)
                VALUES (:id_empleado, :fecha_inicio, :fecha_fin, :motivo)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_empleado', $empleado_id);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->execute();

        $id_licencia = $conn->lastInsertId();

          if ($id_empleado_sustituto) {
            $sql_sust = "INSERT INTO sustituciones (id_licencia, id_empleado_sustituto)
                         VALUES (:id_licencia, :id_empleado_sustituto)";
            $stmt_sust = $conn->prepare($sql_sust);
            $stmt_sust->bindParam(':id_licencia', $id_licencia);
            $stmt_sust->bindParam(':id_empleado_sustituto', $id_empleado_sustituto);
            $stmt_sust->execute();
        }

          $conn->commit();

         $_SESSION['mensaje'] = "Solicitud de licencia registrada correctamente.";
          $_SESSION['tipo_mensaje'] = "success";
    } catch (Throwable $e) {
          if ($conn && $conn->inTransaction()) {
            $conn->rollback();
        }
       //   $_SESSION['mensaje'] = "Error al registrar licencia: " . $e->getMessage();
        // $_SESSION['tipo_mensaje'] = "danger";

        echo "Error al registrar licencia: " . $e->getMessage();
    }

     header("Location: solicitar_licencia.php?empleado_id=$empleado_id");
      exit;
}
?>
