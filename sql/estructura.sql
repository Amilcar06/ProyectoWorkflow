-- Estructura de la base de datos para el sistema de gestión de flujos y solicitudes

-- Tabla: flujoproceso
CREATE TABLE flujoproceso (
  flujo VARCHAR(3),
  proceso VARCHAR(3),
  siguiente VARCHAR(3),
  pantalla VARCHAR(30),
  rol VARCHAR(20),
  PRIMARY KEY (flujo, proceso, siguiente)
);

-- Tabla: flujousuario
CREATE TABLE flujousuario (
  ticket INT,
  usuario VARCHAR(15),
  flujo VARCHAR(3),
  proceso VARCHAR(3),
  fechainicial DATETIME,
  fechafinal DATETIME,
  PRIMARY KEY (ticket, flujo, proceso)
);

-- Tabla: solicitudes
CREATE TABLE solicitudes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ticket INT,
  descripcion TEXT,
  piso VARCHAR(50),
  tipo_reparacion VARCHAR(50),
  observaciones TEXT,
  estado VARCHAR(20) DEFAULT 'pendiente',
  fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
  -- FOREIGN KEY (ticket) REFERENCES flujousuario(ticket) ON DELETE CASCADE
);

-- Tabla: usuarios
CREATE TABLE usuarios (
  usuario VARCHAR(15) PRIMARY KEY,
  nombre VARCHAR(50),
  rol VARCHAR(20)
);