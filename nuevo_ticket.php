<?php
session_start();
include "conexion.inc.php";

$usuario = $_SESSION["usuario"] ?? null;
if (!$usuario) {
    header("Location: login.php");
    exit;
}

$flujo = $_GET["flujo"] ?? null;
if (!$flujo) {
    die("❌ Error: flujo no especificado.");
}

// 1. Obtener nuevo número de trámite
$result = mysqli_query($conexion, "SELECT MAX(nrotramite) AS maxnrotramite FROM flujoseguimiento");
$row = mysqli_fetch_assoc($result);
$nuevo_nrotramite = ($row['maxnrotramite'] ?? 0) + 1;

// 2. Ejecutar lógica personalizada del flujo si existe
$flujoFile = "flujos/$flujo.php";
if (file_exists($flujoFile)) {
    include $flujoFile;  // este archivo puede usar $nuevo_nrotramite y $usuario
}

// 3. Insertar en flujoseguimiento
$proceso = 'P1';
$fecha = date("Y-m-d H:i:s");

$sql_flujo = "
    INSERT INTO flujoseguimiento (nrotramite, flujo, proceso, usuario, fecha_inicio, fecha_fin)
    VALUES ('$nuevo_nrotramite', '$flujo', '$proceso', '$usuario', '$fecha', NULL)
";
if (!mysqli_query($conexion, $sql_flujo)) {
    die("❌ Error al iniciar seguimiento del flujo: " . mysqli_error($conexion));
}

// 4. Redirigir al inicio del flujo
header("Location: inicial.php?flujo=$flujo&proceso=$proceso&nrotramite=$nuevo_nrotramite");
exit;
?>
