<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include "conexion.inc.php";

if (isset($_GET['nuevo']) && $_GET['nuevo'] === 'si') {
    $flujo = $_GET['flujo'] ?? 'F1';
    $usuario = $_SESSION['usuario'];
    $fecha = date("Y-m-d H:i:s");

    // Generar ticket único (puedes mejorar esto según tu lógica)
    $ticket = time(); // o usar AUTO_INCREMENT si ticket es PK

    // Insertar el primer paso del flujo
    $sql = "INSERT INTO flujousuario (ticket, usuario, flujo, proceso, fechainicial, fechafinal)
            VALUES ($ticket, '$usuario', '$flujo', 'P1', '$fecha', NULL)";
    mysqli_query($conexion, $sql);

    header("Location: inicial.php?flujo=$flujo&proceso=P1&ticket=$ticket");
    exit();
}

// Datos enviados por POST
$flujo = $_POST["flujo"] ?? '';
$proceso = $_POST["proceso"] ?? '';
$ticket = intval($_POST["ticket"] ?? 0);
$usuario = $_SESSION["usuario"] ?? '';
$accion = $_POST["accion"] ?? '';
$fecha = date("Y-m-d H:i:s");

// Validación básica
if (empty($flujo) || empty($proceso) || empty($usuario) || $ticket <= 0) {
    die("Error: Datos incompletos.");
}

// Obtener el rol del usuario logueado
$sql_rol_user = "SELECT rol FROM usuarios WHERE usuario = '$usuario'";
$res_rol_user = mysqli_query($conexion, $sql_rol_user);
$datos_user = mysqli_fetch_assoc($res_rol_user);
$rol_usuario = $datos_user["rol"] ?? null;

// Obtener el rol requerido para el proceso actual
$sql_rol_proceso = "SELECT rol FROM flujoproceso 
                    WHERE flujo = '$flujo' AND proceso = '$proceso'";
$res_rol_proceso = mysqli_query($conexion, $sql_rol_proceso);
$datos_proceso = mysqli_fetch_assoc($res_rol_proceso);
$rol_proceso = $datos_proceso["rol"] ?? null;

if (!$rol_usuario || !$rol_proceso || $rol_usuario !== $rol_proceso) {
    die("🚫 Acceso denegado: El proceso '$proceso' requiere el rol '$rol_proceso'.");
}

// Finalizar proceso actual
$sql_update = "UPDATE flujousuario 
               SET fechafinal = '$fecha' 
               WHERE flujo = '$flujo' AND proceso = '$proceso' 
               AND ticket = $ticket AND fechafinal IS NULL";
mysqli_query($conexion, $sql_update);

// Obtener el siguiente proceso por defecto
$sql = "SELECT siguiente FROM flujoproceso 
        WHERE flujo = '$flujo' AND proceso = '$proceso'";
$resultado = mysqli_query($conexion, $sql);
$fila = mysqli_fetch_array($resultado);
$siguiente = $fila["siguiente"] ?? null;

// === GUARDAR DATOS ESPECÍFICOS POR PROCESO ===

// === P1: Ingreso de solicitud ===
if ($proceso === "P1" && $accion === "Siguiente") {
    $descripcion = mysqli_real_escape_string($conexion, $_POST["descripcion"] ?? '');

    $sql_insert = "INSERT INTO solicitudes (ticket, descripcion, estado) 
                   VALUES ($ticket, '$descripcion', 'pendiente')";
    mysqli_query($conexion, $sql_insert);
}

// === P2: Ubicación y tipo de reparación ===
if ($proceso === "P2" && $accion === "Siguiente") {
    $piso = mysqli_real_escape_string($conexion, $_POST["piso"] ?? '');
    $tipo = mysqli_real_escape_string($conexion, $_POST["tipo_reparacion"] ?? '');

    $sql_update = "UPDATE solicitudes 
                   SET piso = '$piso', tipo_reparacion = '$tipo' 
                   WHERE ticket = $ticket";
    mysqli_query($conexion, $sql_update);
}

// === P3: Revisión por supervisor ===
if ($proceso === "P3") {
    if ($accion === "Aprobar") {
        $siguiente = "P4"; // técnico
    } elseif ($accion === "Rechazar") {
        $siguiente = "P5"; // notificación al encargado
        $sql_estado = "UPDATE solicitudes SET estado = 'rechazada' WHERE ticket = $ticket";
        mysqli_query($conexion, $sql_estado);
    } else {
        die("Acción no válida en revisión del supervisor.");
    }
}

// === P4: Ejecución por técnico ===
if ($proceso === "P4" && $accion === "Siguiente") {
    $observaciones = mysqli_real_escape_string($conexion, $_POST["observaciones"] ?? '');

    $sql_update = "UPDATE solicitudes 
                   SET estado = 'ejecutado', observaciones = '$observaciones' 
                   WHERE ticket = $ticket";
    mysqli_query($conexion, $sql_update);
}

// === P5: Confirmación del rechazo ===
// No requiere acción adicional, solo avanza a P6

// === P6: Finalización del proceso ===
if ($proceso === "P6" && $accion === "Siguiente") {
    $sql_finalizar = "UPDATE solicitudes SET estado = 'finalizado' WHERE ticket = $ticket";
    mysqli_query($conexion, $sql_finalizar);

    // Redirigir a la página de inicio
    header("Location: index.php");
    exit();
}

// Validar que haya un proceso siguiente
if (empty($siguiente)) {
    die("Error: No se definió el siguiente proceso.");
}

// Obtener el rol del siguiente proceso
$sql_rol_sig = "SELECT rol FROM flujoproceso WHERE flujo = '$flujo' AND proceso = '$siguiente'";
$res_rol_sig = mysqli_query($conexion, $sql_rol_sig);
$dato_sig = mysqli_fetch_assoc($res_rol_sig);
$rol_siguiente = $dato_sig["rol"] ?? null;

if (!$rol_siguiente) {
    die("Error: No se encontró rol para el proceso siguiente '$siguiente'.");
}

// Obtener un usuario con ese rol (puedes ajustar lógica si hay más de uno)
$sql_user_sig = "SELECT usuario FROM usuarios WHERE rol = '$rol_siguiente' LIMIT 1";
$res_user_sig = mysqli_query($conexion, $sql_user_sig);
$dato_user_sig = mysqli_fetch_assoc($res_user_sig);
$usuario_siguiente = $dato_user_sig["usuario"] ?? null;

if (!$usuario_siguiente) {
    die("Error: No hay usuario asignado con rol '$rol_siguiente'.");
}

// Insertar nuevo paso del flujo con el usuario correcto
$sql_insert_flujo = "INSERT INTO flujousuario 
    (ticket, usuario, flujo, proceso, fechainicial, fechafinal)
    VALUES ($ticket, '$usuario_siguiente', '$flujo', '$siguiente', '$fecha', NULL)";
mysqli_query($conexion, $sql_insert_flujo);


// Redirigir al siguiente proceso
header("Location: inicial.php?flujo=$flujo&proceso=$siguiente&ticket=$ticket");
exit();
