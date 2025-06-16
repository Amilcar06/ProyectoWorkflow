-- === Usuarios ===
INSERT INTO usuarios (usuario, nombre, rol, contrasena) VALUES
('jlopez', 'Juan Lopez', 'encargado', '123456'),
('rfernandez', 'Rosa Fernández', 'supervisor', '123456'),
('mlagos', 'Marcos Lagos', 'tecnico', '123456'),
('mperez', 'Mario Pérez', 'empleado', '123456'),
('rgarcia', 'Ruth García', 'supervisor', '123456'),
('sramirez', 'Silvia Ramírez', 'rrhh', '123456');

-- === Flujo F2: Reparaciones ===
INSERT INTO flujoproceso (flujo, proceso, siguiente, tipo, rol, pantalla) VALUES
('F2', 'P1', 'P2', 'P', 'encargado', 'nuevosolicitud'),
('F2', 'P2', 'P3', 'P', 'encargado', 'ubicacion'),
('F2', 'P3', NULL, 'Q', 'supervisor', 'revision'),
('F2', 'P4', 'P6', 'P', 'tecnico', 'ejecutar'),
('F2', 'P5', 'P6', 'P', 'encargado', 'rechazado'),
('F2', 'P6', NULL, 'E', 'encargado', 'finalizar');

INSERT INTO flujoprocesopregunta (flujo, proceso, si, no) VALUES
('F2', 'P3', 'P4', 'P5');

INSERT INTO solicitudes_mantenimiento (nrotramite, descripcion, piso, tipo_reparacion)
VALUES
    (100, 'Fuga de agua en baño del segundo piso', 'Piso 2', 'Plomería');

INSERT INTO flujoseguimiento (nrotramite, flujo, proceso, usuario, fecha_inicio, fecha_fin) VALUES
(100, 'F2', 'P1', 'jlopez', '2025-06-09 08:00:00', '2025-06-09 08:05:00'),
(100, 'F2', 'P2', 'jlopez', '2025-06-09 08:05:00', '2025-06-09 08:10:00'),
(100, 'F2', 'P3', 'rfernandez', '2025-06-09 08:10:00', NULL);

-- === Flujo F3: Vacaciones ===
INSERT INTO flujoproceso (flujo, proceso, siguiente, tipo, rol, pantalla) VALUES
('F3', 'P1', 'P2', 'P', 'empleado', 'solicitar_vacaciones'),
('F3', 'P2', 'P3', 'P', 'supervisor', 'revisar_solicitud'),
('F3', 'P3', NULL, 'Q', 'supervisor', 'aprobar_solicitud'),
('F3', 'P4', 'P6', 'P', 'rrhh', 'registrar_vacaciones'),
('F3', 'P5', 'P6', 'P', 'supervisor', 'rechazar_solicitud'),
('F3', 'P6', NULL, 'E', 'rrhh', 'finalizar'); -- o 'supervisor' si lo deseas

INSERT INTO flujoprocesopregunta (flujo, proceso, si, no) VALUES
    ('F3', 'P3', 'P4', 'P6');

INSERT INTO solicitudes_vacaciones (nrotramite, empleado_usuario, fecha_desde, fecha_hasta, motivo, estado) VALUES
(1001, 'mperez', '2025-07-01', '2025-07-10', 'Vacaciones anuales', 'pendiente'), -- en revisión
(1002, 'mperez', '2025-12-20', '2025-12-30', 'Visita familiar', 'rechazada'),   -- rechazado
(1003, 'rgarcia', '2025-08-05', '2025-08-15', 'Descanso', 'aprobada');          -- aprobado y registrado


INSERT INTO flujoseguimiento (nrotramite, flujo, proceso, usuario, fecha_inicio, fecha_fin) VALUES
-- Trámite 1001: aún en revisión
(1001, 'F3', 'P1', 'mperez',   '2025-06-10 09:00:00', '2025-06-10 09:05:00'),
(1001, 'F3', 'P2', 'rgarcia',  '2025-06-10 10:00:00', '2025-06-10 10:10:00'),
(1001, 'F3', 'P3', 'rgarcia',  '2025-06-10 10:10:00', NULL),

-- Trámite 1002: rechazado directamente
(1002, 'F3', 'P1', 'mperez',   '2025-06-15 09:00:00', '2025-06-15 09:05:00'),
(1002, 'F3', 'P2', 'rgarcia',  '2025-06-15 10:00:00', '2025-06-15 10:10:00'),
(1002, 'F3', 'P3', 'rgarcia',  '2025-06-15 10:10:00', '2025-06-15 10:20:00'),
(1002, 'F3', 'P6', 'sramirez', '2025-06-15 10:20:00', NULL), -- proceso final tras rechazo

-- Trámite 1003: aprobado → registrado → finalizado
(1003, 'F3', 'P1', 'rgarcia',  '2025-06-20 09:00:00', '2025-06-20 09:05:00'),
(1003, 'F3', 'P2', 'mperez',   '2025-06-20 10:00:00', '2025-06-20 10:10:00'),
(1003, 'F3', 'P3', 'mperez',   '2025-06-20 10:10:00', '2025-06-20 10:20:00'),
(1003, 'F3', 'P4', 'sramirez', '2025-06-21 09:00:00', '2025-06-21 09:10:00'),
(1003, 'F3', 'P6', 'sramirez', '2025-06-21 09:10:00', NULL);
