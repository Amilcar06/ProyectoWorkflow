# Workflow Project

Sistema de Workflow desarrollado en PHP, diseñado para permitir la creación visual de formularios y flujos de trabajo (BPMN), ejecución de procesos, asignación de tareas y seguimiento de solicitudes.

## 📁 Estructura del Proyecto
```
/gestor-wfl/
├── index.php                   // Página inicial
├── motor.php                   // Motor que lee el flujo y decide el siguiente paso
├── reglas.php                  // Evaluador de reglas de negocio
├── pasos.php                   // Controlador centralizado para cada paso del flujo
├── bandeja.php                 // Muestra tareas pendientes del usuario
├── diseñador_formulario.html   // Interfaz drag & drop para crear formularios
├── diseñador_flujo.html        // Interfaz gráfica para crear flujos con nodos
├── flujo.json                  // Definición del flujo en formato JSON
├── formularios.json            // Formularios creados con el diseñador
├── conexion.php                // Conexión a la base de datos
├── utils.php                   // Funciones comunes
├── formbuilder.min.js          // Biblioteca para diseño de formularios
├── jsplumb.min.js              // Biblioteca para diseño gráfico de flujos
└── estilos.css                 // Estilos personalizados

// Archivos que puedes crear luego, según el número de pasos del flujo
├── paso_solicitud.php          // Vista y lógica de un paso del flujo
├── paso_aprobacion.php         // Otro paso
├── paso_ejecucion.php          // Otro paso más
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
git clone https://github.com/Amilcar06/ProyectoWorkflow.git
cd gestor-wfl
```

### 2. Configurar la base de datos
Crear una base de datos en MySQL:

```sql
CREATE DATABASE IF NOT EXISTS workflow_db DEFAULT CHARACTER SET utf8mb4;
```
Importar el esquema desde `/sql/schema.sql` y datos de ejemplo desde `/sql/seed.sql`.

### 3. Configurar el archivo `.env`

```
DB_HOST=localhost
DB_NAME=workflow_db
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
