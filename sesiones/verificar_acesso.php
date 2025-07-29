<?php
session_start();
define('BASE_URL', '/programacion/clinica-db-2');


// Verificar que exista el usuario (puede ser 'id', 'username', etc.)
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['username'])) {
    // Si no hay usuario logueado, redirigir al login

   // echo "NO hay usuario logueado";
    header('Location: ' . BASE_URL . '/sesiones/login.php');
    exit;
}

// Obtener el rol desde la sesión
$rol = $_SESSION['rol'] ?? null;
$pagina_actual = trim(basename($_SERVER['PHP_SELF']));

// Definir los permisos por rol
$permisos = [
    "admin" => [// empleados
                'administrar_cronograma.php', 'buscar_empleados.php', 'carga-empleados.php', 'guardar_cronograma.php',
                'guardar_empleados.php', 'guardar_licencia.php', 'solicitar_licencia.php', 'ver_cronograma.php',
                //medicos
                'agregar_medicos.php', 'buscar_medicos.php', 'consulta_especialidad.php', 'disponibilidad_medicos.php',
                'especialidad_pdf.php', 'guardar_medicos.php', 'solicitar_licencia.php',
                //pacientes
                'agregar_paciente.php', 'buscar_pacientes.php', 'cita_medica.php', 'consulta_informe.php', 'formulario-carga.php',
                 'generar_informe.php', 'generar_pdf.php', 'procesar_reserva.php',

                 // sesiones
                 'buscar_usuario.php','cerrar_sesion.php', 'editar_usuario.php', 'eliminar_usuario.php', 'register.php', 'procesar_editar.php',
                  'procesar_register.php','verificar_acesso.php',

                  // internacion pacientes
                  'cargar_internacion.php', 'editar_internacion.php', 'guardar_internacion.php', 'ver_internacion.php',
                  'actualizar_internacion.php', 'eliminar_internacion.php',

                  //analisis clinico
                  'actualizar_analisis.php', 'crear_analisis.php', 'editar_analisis.php',
                  'eliminar_analisis.php', 'guardar_analisis.php', 'ver_analisis.php',
                  
                  // citas medicas
                   'actualizar_cita.php','crear_cita.php', 'editar_cita.php', 'eliminar_cita.php', 'ver_citas.php',
                   'procesar_reserva.php',
                  
               ],
    "medico" => [
                 'agregar_paciente.php', 'buscar_pacientes.php', 'cita_medica.php', 'consulta_informe.php', 'formulario-carga.php',
                 'generar_informe.php', 'generar_pdf.php', 'procesar_reserva.php'
                ],
    "paciente" => ['buscar_pacientes.php']
];

// Si no hay rol, redirigir al login por seguridad
if (!$rol) {

    header('Location: ' . BASE_URL . '/sesiones/login.php');
    exit;
}


$pagina_actual = htmlspecialchars($pagina_actual);



// Verificar si el rol tiene permiso para acceder a la página actual
if (!in_array($pagina_actual, $permisos[$rol] ?? [])) {
    // Redirigir si no tiene permiso
    header('Location: ' . BASE_URL . '/sesiones/login.php');
    exit;
}


?>
