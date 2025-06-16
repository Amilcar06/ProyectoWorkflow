<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include "conexion.inc.php";

// Utilidades generales
function getCampo($conexion, $sql, $campo) {
    $res = mysqli_query($conexion, $sql);
    $row = mysqli_fetch_assoc($res);
    return $row[$campo] ?? null;
}

function validarRol($conexion, $flujo, $proceso, $usuario) {
    $rol_usuario = getCampo($conexion, "SELECT rol FROM usuarios WHERE usuario = '$usuario'", "rol");
    $rol_proceso = getCampo($conexion, "SELECT rol FROM flujoproceso WHERE flujo = '$flujo' AND proceso = '$proceso'", "rol");
    if (!$rol_usuario || !$rol_proceso || $rol_usuario !== $rol_proceso) {
        die("🚫 Acceso denegado: El proceso '$proceso' requiere el rol '$rol_proceso'.");
    }
}

function siguienteProceso($conexion, $flujo, $proceso, $respuesta) {
    $tipo = getCampo($conexion, "SELECT tipo FROM flujoproceso WHERE flujo = '$flujo' AND proceso = '$proceso'", "tipo");
    if ($tipo === 'Q') {
        $fila = mysqli_fetch_assoc(mysqli_query($conexion,
            "SELECT si, no FROM flujoprocesopregunta WHERE flujo = '$flujo' AND proceso = '$proceso'"));

        $respuesta = strtolower(trim($respuesta));
        if ($respuesta == 'si'){
            return $fila['si'];
        }else{
            return $fila['no'];
        }
    }
    return getCampo($conexion, "SELECT siguiente FROM flujoproceso WHERE flujo = '$flujo' AND proceso = '$proceso'", "siguiente");
}

// Iniciar nuevo flujo
if (isset($_GET['nuevo']) && $_GET['nuevo'] === 'si') {
    $flujo = $_GET['flujo'] ?? 'F2';
    $usuario = $_SESSION['usuario'];
    $nrotramite = getCampo($conexion, "SELECT MAX(nrotramite) as maxtram FROM flujoseguimiento", "maxtram") + 1;
    $fecha = date("Y-m-d H:i:s");

    mysqli_query($conexion, "INSERT INTO flujoseguimiento (nrotramite, usuario, flujo, proceso, fecha_inicio) 
                             VALUES ($nrotramite, '$usuario', '$flujo', 'P1', '$fecha')");
    header("Location: inicial.php?flujo=$flujo&proceso=P1&nrotramite=$nrotramite");
    exit();
}

// Procesar datos del flujo
$flujo = $_POST["flujo"] ?? '';
$proceso = $_POST["proceso"] ?? '';
$nrotramite = intval($_POST["nrotramite"] ?? 0);
$accion = $_POST["accion"] ?? '';
$usuario = $_SESSION["usuario"];
$fecha = date("Y-m-d H:i:s");

if (!$flujo || !$proceso || !$nrotramite || !$usuario) die("Error: Datos incompletos.");
validarRol($conexion, $flujo, $proceso, $usuario);

// Cerrar proceso actual
mysqli_query($conexion, "UPDATE flujoseguimiento SET fecha_fin = '$fecha'
                         WHERE flujo = '$flujo' AND proceso = '$proceso' AND nrotramite = $nrotramite AND fecha_fin IS NULL");

// === FLUJO DE MANTENIMIENTO (F2) ===
if ($flujo === "F2") {
    switch ($proceso) {
        case "P1":
            if ($accion === "Siguiente") {
                $desc = mysqli_real_escape_string($conexion, $_POST["descripcion"] ?? '');
                mysqli_query($conexion, "INSERT INTO solicitudes_mantenimiento (nrotramite, descripcion, estado)
                                         VALUES ($nrotramite, '$desc', 'pendiente')");
            }
            break;
        case "P2":
            if ($accion === "Siguiente") {
                $piso = mysqli_real_escape_string($conexion, $_POST["piso"] ?? '');
                $tipo = mysqli_real_escape_string($conexion, $_POST["tipo_reparacion"] ?? '');
                mysqli_query($conexion, "UPDATE solicitudes_mantenimiento SET piso = '$piso', tipo_reparacion = '$tipo'
                                         WHERE nrotramite = $nrotramite");
            }
            break;
        case "P3":
            if ($accion === "Aprobar") {
                $siguiente = "P4";
            } elseif ($accion === "Rechazar") {
                $siguiente = "P5";
                mysqli_query($conexion, "UPDATE solicitudes_mantenimiento SET estado = 'rechazada'
                                         WHERE nrotramite = $nrotramite");
            } else die("Acción inválida en revisión.");
            break;
        case "P4":
            if ($accion === "Siguiente") {
                $obs = mysqli_real_escape_string($conexion, $_POST["observaciones"] ?? '');
                mysqli_query($conexion, "UPDATE solicitudes_mantenimiento SET observaciones = '$obs', estado = 'ejecutado'
                                         WHERE nrotramite = $nrotramite");
            }
            break;
        case "P6":
            if ($accion === "Siguiente") {
                mysqli_query($conexion, "UPDATE solicitudes_mantenimiento SET estado = 'finalizado'
                                         WHERE nrotramite = $nrotramite");
                header("Location: index.php");
                exit();
            }
            break;
    }
}

// === FLUJO DE VACACIONES (F3) ===
if ($flujo === "F3") {
    switch ($proceso) {
        case "P1":
            if ($accion === "Siguiente") {
                $desde = mysqli_real_escape_string($conexion, $_POST["fecha_desde"] ?? '');
                $hasta = mysqli_real_escape_string($conexion, $_POST["fecha_hasta"] ?? '');
                $motivo = mysqli_real_escape_string($conexion, $_POST["motivo"] ?? '');
                $existe = getCampo($conexion, "SELECT COUNT(*) as total FROM solicitudes_vacaciones WHERE nrotramite = $nrotramite", "total");

                if ($existe == 0) {
                    mysqli_query($conexion, "INSERT INTO solicitudes_vacaciones 
                        (nrotramite, empleado_usuario, fecha_desde, fecha_hasta, motivo, estado)
                        VALUES ($nrotramite, '$usuario', '$desde', '$hasta', '$motivo', 'pendiente')");
                } else {
                    mysqli_query($conexion, "UPDATE solicitudes_vacaciones 
                        SET fecha_desde = '$desde', fecha_hasta = '$hasta', motivo = '$motivo'
                        WHERE nrotramite = $nrotramite");
                }
            }
            break;
        case "P3":
            $respuesta = $_POST["respuesta"] ?? '';
            if ($respuesta === "si") {
                mysqli_query($conexion, "UPDATE solicitudes_vacaciones SET estado = 'aprobada'
                                         WHERE nrotramite = $nrotramite");
                $siguiente = siguienteProceso($conexion, $flujo, $proceso, $respuesta);
                $proceso = $siguiente;
            } elseif ($respuesta === "no") {
                mysqli_query($conexion, "UPDATE solicitudes_vacaciones SET estado = 'rechazada'
                                         WHERE nrotramite = $nrotramite");
                $siguiente = siguienteProceso($conexion, $flujo, $proceso, $respuesta);
                $proceso = $siguiente;
            } else die("Respuesta inválida.");
            break;
        case "P4":
            if ($accion === "Siguiente") {
                mysqli_query($conexion, "UPDATE solicitudes_vacaciones SET estado = 'registrada'
                                         WHERE nrotramite = $nrotramite");
            }
            break;
        case "P6":
            if ($accion === "Siguiente") {
                mysqli_query($conexion, "UPDATE solicitudes_vacaciones SET estado = 'finalizado'
                                         WHERE nrotramite = $nrotramite");
                header("Location: index.php");
                exit();
            }
            break;
    }
}

// === Determinar siguiente proceso ===
if (!isset($siguiente)) {
    $siguiente = siguienteProceso($conexion, $flujo, $proceso, $accion);
}

if (!$siguiente) die("Error: No se definió el siguiente proceso.");

$rol_siguiente = getCampo($conexion, "SELECT rol FROM flujoproceso WHERE flujo = '$flujo' AND proceso = '$siguiente'", "rol");
$usuario_siguiente = getCampo($conexion, "SELECT usuario FROM usuarios WHERE rol = '$rol_siguiente' LIMIT 1", "usuario");

if (!$usuario_siguiente) die("Error: No hay usuario con rol '$rol_siguiente'.");

mysqli_query($conexion, "INSERT INTO flujoseguimiento 
    (nrotramite, usuario, flujo, proceso, fecha_inicio)
    VALUES ($nrotramite, '$usuario_siguiente', '$flujo', '$siguiente', '$fecha')");

header("Location: inicial.php?flujo=$flujo&proceso=$siguiente&nrotramite=$nrotramite");
exit();
?>
