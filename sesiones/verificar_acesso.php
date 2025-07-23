<?php
session_start();


// Verificar que exista el usuario (puede ser 'id', 'username', etc.)
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['username'])) {
    // Si no hay usuario logueado, redirigir al login

   // echo "NO hay usuario logueado";
    header('Location: ../sesiones/login.php');
    exit;
}

// Obtener el rol desde la sesión
$rol = $_SESSION['rol'] ?? null;
$pagina_actual = trim(basename($_SERVER['PHP_SELF']));

// Definir los permisos por rol
$permisos = [
    "admin" => [// empleados
                'administrar_cronograma.php', 'buscar_empleados.php', 'carga-empleados.php', 'guardar_cronograma.php',
                'guardar_empleados.php', 'guardar_licencia.php', 'solicitar_licencia.php', 'ver_cronograma',
                //medicos
                'agregar_medicos.php', 'buscar_medicos.php', 'consulta_especialidad.php', 'disponibilidad_medicos.php',
                'especialidad_pdf.php', 'guardar_medicos.php', 'solicitar_licencia.php',
                //pacientes
                'agregar_paciente.php', 'buscar_pacientes.php', 'cita_medica.php', 'consulta_informe.php', 'formulario-carga.php',
                 'generar_informe.php', 'generar_pdf.php', 'procesar_reserva.php'
               ],
    "medico" => [
                 'agregar_paciente.php', 'buscar_pacientes.php', 'cita_medica.php', 'consulta_informe.php', 'formulario-carga.php',
                 'generar_informe.php', 'generar_pdf.php', 'procesar_reserva.php'
                ],
    "paciente" => ['buscar_pacientes.php']
];

// Si no hay rol, redirigir al login por seguridad
if (!$rol) {

    header('Location: ../sesiones/login.php');
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
