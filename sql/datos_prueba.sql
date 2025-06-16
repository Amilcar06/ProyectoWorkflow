-- === Usuarios ===
INSERT INTO usuarios (usuario, nombre, rol, contrasena) VALUES
('rfernandez', 'Rosa Fernández', 'supervisor', '123456'),
('mlagos', 'Marcos Lagos', 'tecnico', '123456'),
('mperez', 'Mario Pérez', 'empleado', '123456'),
('sramirez', 'Silvia Ramírez', 'rrhh', '123456');

-- === Flujo F2: Reparaciones ===
INSERT INTO flujoproceso (flujo, proceso, siguiente, tipo, rol, pantalla) VALUES
('F2', 'P1', 'P2', 'P', 'empleado', 'nuevosolicitud'),
('F2', 'P2', 'P3', 'P', 'empleado', 'ubicacion'),
('F2', 'P3', NULL, 'Q', 'supervisor', 'revision'),
('F2', 'P4', 'P6', 'P', 'tecnico', 'ejecutar'),
('F2', 'P5', 'P6', 'P', 'empleado', 'rechazado'),
('F2', 'P6', NULL, 'E', 'empleado', 'finalizar');

INSERT INTO flujoprocesopregunta (flujo, proceso, si, no) VALUES
('F2', 'P3', 'P4', 'P5');

INSERT INTO solicitudes_mantenimiento (nrotramite, descripcion, piso, tipo_reparacion)
VALUES
    (1, 'Fuga de agua en baño del segundo piso', 'Piso 2', 'Plomería');

INSERT INTO flujoseguimiento (nrotramite, flujo, proceso, usuario, fecha_inicio, fecha_fin) VALUES
(1, 'F2', 'P1', 'mperez', '2025-06-09 08:00:00', '2025-06-09 08:05:00'),
(1, 'F2', 'P2', 'mperez', '2025-06-09 08:05:00', '2025-06-09 08:10:00'),
(1, 'F2', 'P3', 'rfernandez', '2025-06-09 08:10:00', NULL);

-- === Flujo F3: Vacaciones ===
INSERT INTO flujoproceso (flujo, proceso, siguiente, tipo, rol, pantalla) VALUES
('F3', 'P1', 'P2', 'P', 'empleado', 'solicitar_vacaciones'),
('F3', 'P2', 'P3', 'P', 'supervisor', 'revisar_solicitud'),
('F3', 'P3', NULL, 'Q', 'supervisor', 'aprobar_solicitud'),
('F3', 'P4', 'P6', 'P', 'rrhh', 'registrar_vacaciones'),
('F3', 'P5', 'P6', 'P', 'empleado', 'rechazado'),
('F3', 'P6', NULL, 'E', 'empleado', 'finalizar');

INSERT INTO flujoprocesopregunta (flujo, proceso, si, no) VALUES
    ('F3', 'P3', 'P4', 'P5');

INSERT INTO solicitudes_vacaciones (nrotramite, empleado_usuario, fecha_desde, fecha_hasta, motivo, estado) VALUES
(2, 'mperez', '2025-07-01', '2025-07-10', 'Vacaciones anuales', 'pendiente');

INSERT INTO flujoseguimiento (nrotramite, flujo, proceso, usuario, fecha_inicio, fecha_fin) VALUES
-- Trámite 2: aún en revisión
(2, 'F3', 'P1', 'mperez',   '2025-06-10 09:00:00', '2025-06-10 09:05:00'),
(2, 'F3', 'P2', 'rfernandez',  '2025-06-10 10:00:00', '2025-06-10 10:10:00'),
(2, 'F3', 'P3', 'rfernandez',  '2025-06-10 10:10:00', NULL);
