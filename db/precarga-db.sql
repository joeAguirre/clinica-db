-- Precarga de tipo_sangre
INSERT INTO tipo_sangre (nombre) VALUES 
('A+'),
('A-'),
('B+'),
('B-'),
('AB+'),
('AB-'),
('O+'),
('O-');

-- Precarga de obra_social (principales de Argentina)
INSERT INTO obra_social (nombre) VALUES 
('PAMI'),
('OSDE'),
('Swiss Medical'),
('Galeno'),
('Medifé'),
('OMINT'),
('OSDEPYM'),
('OSPIM'),
('OSPAT'),
('IOSFA'),
('IOMA'),
('Federada Salud'),
('Sancor Salud');

-- Precarga de dias_semana
INSERT INTO dias_semana (id_dia, nombre) VALUES 
(1, 'Lunes'),
(2, 'Martes'),
(3, 'Miércoles'),
(4, 'Jueves'),
(5, 'Viernes')

/* precarga roles */
INSERT INTO roles (nombre) VALUES
('admin'),
('medico'),
('paciente');

/* cargar una persona */
INSERT INTO personas (
  nombre,
  apellido,
  fecha_nacimiento,
  direccion,
  telefono,
  email
) VALUES (
  'Juanito',
  'Pérez',
  '1990-05-15',
  'Calle Falsa 123',
  '1234567890',
  'juanito@example.com'
);

