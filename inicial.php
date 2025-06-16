<?php
session_start();
include "conexion.inc.php";

// Recuperar variables de URL
$flujo = $_GET["flujo"] ?? null;
$proceso = $_GET["proceso"] ?? null;
$nrotramite = $_GET["nrotramite"] ?? null;
$usuario = $_SESSION["usuario"] ?? null;

// 1. Verificar sesión
if (!$usuario) {
    header("Location: login.php");
    exit;
}

// 2. Validar parámetros esenciales
if (!$flujo || !$proceso || !$nrotramite) {
    die("❌ Error: Parámetros incompletos.");
}

// 3. Obtener el rol del usuario actual
$sql = "SELECT rol FROM usuarios WHERE usuario = '$usuario'";
$resultado = mysqli_query($conexion, $sql);
$datos = mysqli_fetch_assoc($resultado);
$rolUsuario = $datos["rol"] ?? null;

// 4. Obtener el rol requerido y la pantalla del proceso actual
$sql = "SELECT rol, pantalla FROM flujoproceso WHERE flujo = '$flujo' AND proceso = '$proceso' LIMIT 1";
$resultado = mysqli_query($conexion, $sql);
$datos = mysqli_fetch_assoc($resultado);
$rolProceso = $datos["rol"] ?? null;
$pantalla = $datos["pantalla"] ?? null;

// 5. Validar acceso por rol
if ($rolUsuario !== $rolProceso) {
    echo "<h3>🚫 Acceso denegado: este paso del flujo requiere el rol <b>$rolProceso</b>.</h3>";
    echo "<p><a href='bandeja/entrada.php'>🔙 Volver a la bandeja</a></p>";
    exit;
}

// 6. Determinar carpeta según el flujo
$carpeta = match ($flujo) {
    'F2' => 'mantenimiento',
    'F3' => 'vacaciones',
    default => 'generico', // Puedes tener una carpeta 'generico' o lanzar error
};

// 7. Incluir la pantalla correspondiente
$ruta = "inc/$carpeta/$pantalla.inc.php";
if ($pantalla && file_exists($ruta)) {
    include $ruta;
} else {
    echo "<h3>❌ Pantalla no encontrada: <code>$ruta</code></h3>";
    echo "<p><a href='bandeja/entrada.php'>🔙 Volver a la bandeja</a></p>";
}
?>
