<?php
session_start();
include "conexion.inc.php";

// Recuperar variables de URL
$flujo = $_GET["flujo"];
$proceso = $_GET["proceso"];
$ticket = $_GET["ticket"] ?? null;
$usuario = $_SESSION["usuario"] ?? null;

// 1. Verificar sesión
if (!$usuario) {
    header("Location: login.php");
    exit;
}

// 2. Obtener el rol del usuario actual
$sql = "SELECT rol FROM usuarios WHERE usuario = '$usuario'";
$resultado = mysqli_query($conexion, $sql);
$datos = mysqli_fetch_assoc($resultado);
$rolUsuario = $datos["rol"] ?? null;

// 3. Obtener el rol requerido para el proceso actual
$sql = "SELECT rol, pantalla FROM flujoproceso WHERE flujo = '$flujo' AND proceso = '$proceso' LIMIT 1";
$resultado = mysqli_query($conexion, $sql);
$datos = mysqli_fetch_assoc($resultado);
$rolProceso = $datos["rol"] ?? null;
$pantalla = $datos["pantalla"] ?? null;

// 4. Validar acceso por rol
if ($rolUsuario !== $rolProceso) {
    echo "<h3>🚫 Acceso denegado: este paso del flujo requiere el rol <b>$rolProceso</b>.</h3>";
    echo "<p><a href='bandeja/entrada.php'>🔙 Volver a la bandeja</a></p>";
    exit;
}

// 5. Incluir la pantalla correspondiente
if ($pantalla && file_exists("inc/$pantalla.inc.php")) {
    include "inc/$pantalla.inc.php";
} else {
    echo "<h3>❌ Pantalla no encontrada: <code>$pantalla.inc.php</code></h3>";
}
?>
