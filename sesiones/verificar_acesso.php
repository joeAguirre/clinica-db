<?php
session_start();

// Verificar que exista el usuario (puede ser 'id', 'username', etc.)
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['username'])) {
    // Si no hay usuario logueado, redirigir al login

    echo "NO hay usuario logueado";
   // header('Location: ../sesiones/login.php');
    exit;
}

// Obtener el rol desde la sesión
$rol = $_SESSION['rol'] ?? null;
$pagina_actual = trim(basename($_SERVER['PHP_SELF']));

// Definir los permisos por rol
$permisos = [
    "admin" => ['administrar_cronograma.php', 'buscar_empleados.php', 'carga-empleados.php', 'guardar_cronograma.php',
                'guardar_empleados.php', 'guardar_licencia.php', 'solicitar_licencia.php', 'ver_cronograma'
               ],
    "medico" => ['cronograma.php', 'ver_turnos.php'],
    "paciente" => []
];

// Si no hay rol, redirigir al login por seguridad
if (!$rol) {
    echo "No existe rol";

   // header('Location: ../sesiones/login.php');
    exit;
}


$pagina_actual = htmlspecialchars($pagina_actual);



// Verificar si el rol tiene permiso para acceder a la página actual
if (!in_array($pagina_actual, $permisos[$rol] ?? [])) {
    // Redirigir si no tiene permiso
    header('Location: ../sesiones/login.php');
    exit;
}


?>
