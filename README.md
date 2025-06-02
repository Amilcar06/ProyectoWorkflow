# BPM Project

Sistema de Gestión de Procesos de Negocio (Business Process Management - BPM) desarrollado en PHP, diseñado para permitir la creación visual de formularios y flujos de trabajo (BPMN), ejecución de procesos, asignación de tareas y seguimiento de solicitudes.

## 📁 Estructura del Proyecto
```
/bpm-project/
│
├── /public/                          # Carpeta pública accesible desde el navegador
│   ├── index.php                     # Punto de entrada principal
│   ├── login.php                     # Página de inicio de sesión
│   ├── register.php                  # Página de registro
│   ├── dashboard.php                 # Panel principal
│   ├── /assets/                      # Archivos estáticos
│   │   ├── /css/
│   │   │   ├── style.css
│   │   │   └── bootstrap.min.css
│   │   ├── /js/
│   │   │   ├── main.js
│   │   │   ├── form-designer.js
│   │   │   └── flow-designer.js
│   │   └── /img/
│   │       └── logo.png
│   ├── /form-designer/              # Interfaz visual FormBuilder
│   │   └── index.php
│   └── /flow-designer/              # Interfaz visual BPMN
│       └── index.php
│
├── /app/
│   ├── /controllers/                # Lógica de backend
│   │   ├── AuthController.php       # Login, logout, registro
│   │   ├── UserController.php       # Gestión de usuarios/roles
│   │   ├── FormController.php       # Crear, editar, ver formularios
│   │   ├── FlowController.php       # Crear, editar, ver flujos
│   │   ├── ProcessController.php    # Crear solicitud, iniciar proceso
│   │   └── ProcessEngine.php        # Motor de ejecución BPMN
│   │
│   ├── /models/                     # Modelos conectados a la base de datos
│   │   ├── User.php
│   │   ├── Role.php
│   │   ├── Form.php
│   │   ├── Flow.php
│   │   ├── Process.php              # Solicitud
│   │   ├── Task.php                 # Tarea de usuario
│   │   └── AuditLog.php             # Auditoría
│   │
│   ├── /views/                      # Interfaces de usuario
│   │   ├── /auth/                   # Login / Registro
│   │   │   ├── login.php
│   │   │   └── register.php
│   │   ├── /user/                   # CRUD de usuarios
│   │   │   └── list.php
│   │   ├── /form/                   # Formularios
│   │   │   ├── list.php
│   │   │   └── create.php
│   │   ├── /flow/                   # Flujos BPMN
│   │   │   ├── list.php
│   │   │   └── create.php
│   │   ├── /process/               # Solicitudes
│   │   │   ├── my_requests.php
│   │   │   └── inbox.php
│   │   └── /partials/              # Componentes comunes
│   │       ├── header.php
│   │       └── footer.php
│   │
│   └── /core/                       # Clases base y utilidades
│       ├── Database.php             # Conexión PDO
│       ├── Router.php               # Ruteo básico
│       ├── Session.php              # Manejo de sesiones
│       ├── Auth.php                 # Verificación de permisos
│       └── Helpers.php              # Funciones comunes
│
├── /storage/                        # Archivos generados o temporales
│   ├── forms/                       # Formularios en JSON
│   ├── flows/                       # Flujos en XML
│   ├── logs/                        # Logs del motor
│   └── uploads/                     # Archivos adjuntos (ej. boletas)
│
├── /config/                         # Configuración del sistema
│   ├── db.php                       # Configuración base de datos
│   └── mail.php                     # Parámetros de envío de correos
│
├── /sql/                            # Migraciones y scripts de base de datos
│   ├── schema.sql                   # Script inicial
│   └── seed.sql                     # Datos de prueba
│
├── /tests/                          # Pruebas unitarias o funcionales
│   ├── FormTest.php
│   └── FlowExecutionTest.php
│
├── composer.json                    # Dependencias PHP (si usas Composer)
├── package.json                     # Dependencias JS (si usas npm/yarn)
├── README.md                        # Documentación principal
└── .env                             # Variables de entorno (opcional)
```
--- 

## ⚙️ Funcionalidades Principales

- 🔐 Autenticación de usuarios y gestión de roles.
- 🧩 Constructor visual de formularios (form-designer).
- 🧭 Editor visual de flujos BPMN (flow-designer).
- 📑 Creación, edición y ejecución de solicitudes.
- 👤 Asignación y seguimiento de tareas de usuario.
- 📋 Auditoría de acciones y eventos (logs).
- 📨 Sistema de notificaciones (opcional).
- 🧠 Reglas de decisión integradas en los procesos.

---

## 🧱 Requisitos del Sistema

- PHP >= 8.0
- Servidor Web (Apache o Nginx)
- MySQL o MariaDB
- Composer (si se usan dependencias PHP)
- Node.js y npm (si se usan herramientas JS adicionales)

---

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu_usuario/bpm-project.git
cd bpm-project
```

### 2. Configurar la base de datos
Crear una base de datos en MySQL:

```sql
CREATE DATABASE bpm_project CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
Importar el esquema desde `/sql/schema.sql` y datos de ejemplo desde `/sql/seed.sql`.

### 3. Configurar el archivo `.env`

```
DB_HOST=localhost
DB_NAME=bpm_project
DB_USER=root
DB_PASS=tu_contraseña
```

### 4. Configurar Apache/Nginx

Configurar el documento raíz en `/public` para apuntar a `index.php`.

---

## 👨‍💻 Uso del Sistema
- **Acceso:**  
  - Iniciar sesión en `/login.php`
  - Registro de nuevos usuarios en `/register.php`
  - Panel principal en `/dashboard.php`

- **Módulos:**  
  - Formularios: Diseñar y listar en `/form-designer/`
  - Flujos BPMN: Crear y editar en `/flow-designer/`
  - Solicitudes: Iniciar procesos desde formularios asignados
  - Tareas: Visualización en bandeja de entrada `/process/inbox.php`
  - Seguimiento: Revisión de solicitudes enviadas en `/process/my_requests.php`

---

## 🧪 Pruebas
Las pruebas unitarias están en el directorio `/tests/`.

Ejecuta pruebas con PHPUnit si está configurado

```bash
./vendor/bin/phpunit tests/
```

---

## 📦 Herramientas y Librerías Recomendadas

- **FormBuilder** para diseño de formularios
- **bpmn-js** para edición de procesos BPMN
- **Bootstrap** para interfaz responsiva
- **jQuery** y **JavaScript** para la interacción

---

## 🛠 Estructura de Base de Datos

La base de datos incluye:

- Usuarios y roles
- Formularios con JSON
- Flujos BPMN en XML
- Solicitudes con estado y datos
- Tareas asignadas
- Logs de auditoría
- Reglas de decisión (opcional)

Consultar el archivo [`sql/schema.sql`](../sql/schema.sql) para detalles.

---

## 📚 Créditos y Autoría

Este proyecto ha sido desarrollado por **Amilcar Josias Yujra Chipana** con fines académicos y funcionales, usando buenas prácticas de desarrollo en PHP y diseño MVC.

---

## 📝 Licencia
Este proyecto se distribuye bajo una licencia libre para uso académico o interno. Para usos comerciales, por favor contactar al autor.
