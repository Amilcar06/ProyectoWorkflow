-- Tabla: usuarios
CREATE TABLE usuarios (
id INT AUTO_INCREMENT PRIMARY KEY,
usuario VARCHAR(20) NOT NULL UNIQUE,
contrasena VARCHAR(20) NOT NULL,
nombre VARCHAR(50),
rol VARCHAR(20)
);

-- Tabla: flujoproceso
CREATE TABLE flujoproceso (
flujo VARCHAR(3) NOT NULL,
proceso VARCHAR(3) NOT NULL,
siguiente VARCHAR(3) DEFAULT NULL,
tipo CHAR(1) NOT NULL DEFAULT 'P',  -- P = Proceso, Q = Pregunta, E = Fin
rol VARCHAR(20),
pantalla VARCHAR(30),
PRIMARY KEY (flujo, proceso)
);

-- Tabla: flujoprocesopregunta (solo para procesos tipo 'Q')
CREATE TABLE flujoprocesopregunta (
flujo VARCHAR(3) NOT NULL,
proceso VARCHAR(3) NOT NULL,
si VARCHAR(3),
no VARCHAR(3),
PRIMARY KEY (flujo, proceso)
);

-- Tabla: solicitudes mantenimiento (contenido de cada solicitud)
CREATE TABLE solicitudes_mantenimiento (
id INT AUTO_INCREMENT PRIMARY KEY,
nrotramite INT,  -- Se vincula con flujoseguimiento
descripcion TEXT,
piso VARCHAR(50),
tipo_reparacion VARCHAR(50),
observaciones TEXT,
estado VARCHAR(20) DEFAULT 'pendiente',
fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla: solicitudes vacaciones (contenido de cada solicitud)
CREATE TABLE solicitudes_vacaciones (
id INT AUTO_INCREMENT PRIMARY KEY,
nrotramite INT UNIQUE,
empleado_usuario VARCHAR(20),
fecha_desde DATE,
fecha_hasta DATE,
motivo TEXT,
estado VARCHAR(20) DEFAULT 'pendiente',
fecha_solicitud DATETIME DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (empleado_usuario) REFERENCES usuarios(usuario)
);

-- Tabla: flujoseguimiento (historial de cada proceso por trámite)
CREATE TABLE flujoseguimiento (
nrotramite INT,
flujo VARCHAR(3),
proceso VARCHAR(3),
usuario VARCHAR(20),
fecha_inicio DATETIME,
fecha_fin DATETIME,
PRIMARY KEY (nrotramite, flujo, proceso)
);
