CREATE TABLE `paises` (
  `id_pais` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL
);

CREATE TABLE `provincias` (
  `id_provincia` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `id_pais` int
);

CREATE TABLE `departamentos` (
  `id_departamento` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `id_provincia` int
);

CREATE TABLE `municipio` (
  `id_municipio` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `id_departamento` int
);

CREATE TABLE `personas` (
  `id_persona` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_municipio` int
);

CREATE TABLE `empleados` (
  `empleado_id` int PRIMARY KEY AUTO_INCREMENT,
  `id_persona` int,
  `codigo_empleado` varchar(50),
  `estado` boolean
);

CREATE TABLE `medicos` (
  `id_medico` int PRIMARY KEY AUTO_INCREMENT,
  `empleado_id` int,
  `id_especialidad` int,
  `codigo_medico` varchar(20)
);

CREATE TABLE `cita_medica` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `id_paciente` int,
  `id_medico` int,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
);

CREATE TABLE `obra_social` (
  `id_obra_social` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL
);

CREATE TABLE `tipo_sangre` (
  `id_tipo_sangre` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(10) NOT NULL
);

CREATE TABLE `pacientes` (
  `id_paciente` int PRIMARY KEY AUTO_INCREMENT,
  `id_persona` int NOT NULL,
  `numero_afiliado` varchar(100) NOT NULL,
  `id_obra_social` int NOT NULL,
  `id_tipo_sangre` int NOT NULL
);

CREATE TABLE `roles` (
  `id_rol` int PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL
);

CREATE TABLE `usuarios` (
  `id_usuario` int PRIMARY KEY AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_persona` int NOT NULL,
  `id_rol` int NOT NULL
);

CREATE TABLE `internacion` (
  `id_internacion` int PRIMARY KEY AUTO_INCREMENT,
  `id_paciente` int NOT NULL,
  `fecha_ingreso` date NOT NULL,
  `fecha_egreso` date,
  `motivo` varchar(255) NOT NULL
);

CREATE TABLE `analisis_clinico` (
  `id_analisis` int PRIMARY KEY AUTO_INCREMENT,
  `id_paciente` int NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `descripcion` text,
  `resultado` text,
  `fecha` date NOT NULL
);

CREATE TABLE `licencias` (
  `id_licencia` int PRIMARY KEY AUTO_INCREMENT,
  `id_empleado` int NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `motivo` varchar(255)
);

CREATE TABLE `sustituciones` (
  `id_sustitucion` int PRIMARY KEY AUTO_INCREMENT,
  `id_licencia` int NOT NULL,
  `id_empleado_sustituto` int NOT NULL
);

CREATE TABLE `dias_semana` (
  `id_dia` int PRIMARY KEY,
  `nombre` varchar(20) NOT NULL
);

CREATE TABLE `cronograma_empleado` (
  `id_cronograma` int PRIMARY KEY AUTO_INCREMENT,
  `id_empleado` int NOT NULL,
  `id_dia` int NOT NULL,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL
);

CREATE TABLE `especialidades` (
  `id_especialidad` int PRIMARY KEY,
  `nombre` varchar(100)
);

ALTER TABLE `medicos` ADD FOREIGN KEY (`id_especialidad`) REFERENCES `especialidades` (`id_especialidad`);

ALTER TABLE `provincias` ADD FOREIGN KEY (`id_pais`) REFERENCES `paises` (`id_pais`);

ALTER TABLE `departamentos` ADD FOREIGN KEY (`id_provincia`) REFERENCES `provincias` (`id_provincia`);

ALTER TABLE `municipio` ADD FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`);

ALTER TABLE `personas` ADD FOREIGN KEY (`id_municipio`) REFERENCES `municipio` (`id_municipio`);

ALTER TABLE `empleados` ADD FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

ALTER TABLE `medicos` ADD FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`empleado_id`);

ALTER TABLE `cita_medica` ADD FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`);

ALTER TABLE `cita_medica` ADD FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`);

ALTER TABLE `pacientes` ADD FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

ALTER TABLE `pacientes` ADD FOREIGN KEY (`id_obra_social`) REFERENCES `obra_social` (`id_obra_social`);

ALTER TABLE `pacientes` ADD FOREIGN KEY (`id_tipo_sangre`) REFERENCES `tipo_sangre` (`id_tipo_sangre`);

ALTER TABLE `usuarios` ADD FOREIGN KEY (`id_persona`) REFERENCES `personas` (`id_persona`);

ALTER TABLE `usuarios` ADD FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

ALTER TABLE `internacion` ADD FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`);

ALTER TABLE `analisis_clinico` ADD FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id_paciente`);

ALTER TABLE `licencias` ADD FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`empleado_id`);

ALTER TABLE `sustituciones` ADD FOREIGN KEY (`id_licencia`) REFERENCES `licencias` (`id_licencia`);

ALTER TABLE `sustituciones` ADD FOREIGN KEY (`id_empleado_sustituto`) REFERENCES `empleados` (`empleado_id`);

ALTER TABLE `cronograma_empleado` ADD FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`empleado_id`);

ALTER TABLE `cronograma_empleado` ADD FOREIGN KEY (`id_dia`) REFERENCES `dias_semana` (`id_dia`);
