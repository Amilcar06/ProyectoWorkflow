
-- === Datos de prueba ===

-- Usuarios
INSERT INTO usuarios VALUES ('jlopez', 'Juan Lopez', 'encargado');
INSERT INTO usuarios VALUES ('rfernandez', 'Rosa Fernández', 'supervisor');
INSERT INTO usuarios VALUES ('mlagos', 'Marcos Lagos', 'tecnico');

-- Flujo de procesos
INSERT INTO flujoproceso VALUES ('F2', 'P1', 'P2', 'nuevosolicitud', 'encargado');
INSERT INTO flujoproceso VALUES ('F2', 'P2', 'P3', 'ubicacion', 'encargado');
INSERT INTO flujoproceso VALUES ('F2', 'P3', 'P4', 'revision', 'supervisor');  -- Aprobación
INSERT INTO flujoproceso VALUES ('F2', 'P3', 'P5', 'revision', 'supervisor');  -- Rechazo
INSERT INTO flujoproceso VALUES ('F2', 'P4', 'P6', 'ejecutar', 'tecnico');
INSERT INTO flujoproceso VALUES ('F2', 'P5', 'P6', 'rechazado', 'encargado');
INSERT INTO flujoproceso VALUES ('F2', 'P6', '-', 'finalizar', 'encargado');

-- Ejemplo de flujo de usuario
INSERT INTO flujousuario VALUES (100, 'jlopez', 'F2', 'P1', '2025-06-09 08:00:00', '2025-06-09 08:05:00');
INSERT INTO flujousuario VALUES (100, 'jlopez', 'F2', 'P2', '2025-06-09 08:05:00', '2025-06-09 08:10:00');
INSERT INTO flujousuario VALUES (100, 'rfernandez', 'F2', 'P3', '2025-06-09 08:10:00', NULL);

-- Solicitud asociada
INSERT INTO solicitudes (ticket, descripcion, piso, tipo_reparacion)
VALUES (100, 'Fuga de agua en baño del segundo piso', 'Piso 2', 'Plomería');