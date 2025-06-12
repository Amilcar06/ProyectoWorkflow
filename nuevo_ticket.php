<?php
session_start();
include "conexion.inc.php";

// Verificar usuario logueado
$usuario = $_SESSION["usuario"] ?? null;
if (!$usuario) {
    header("Location: ../login.php");
    exit;
}

// Generar nuevo número de ticket (puedes usar MAX o AUTO_INCREMENT de solicitudes)
$result = mysqli_query($conexion, "SELECT MAX(ticket) AS maxticket FROM flujousuario");
$row = mysqli_fetch_assoc($result);
$nuevo_ticket = $row['maxticket'] + 1;

// Insertar primera entrada del flujo
$flujo = 'F2';
$proceso = 'P1';
$fecha = date("Y-m-d H:i:s");

$sql = "INSERT INTO flujousuario (ticket, usuario, flujo, proceso, fechainicial, fechafinal)
        VALUES ('$nuevo_ticket', '$usuario', '$flujo', '$proceso', '$fecha', NULL)";
mysqli_query($conexion, $sql);

// Redirigir al usuario al inicio del flujo
header("Location: inicial.php?flujo=$flujo&proceso=$proceso&ticket=$nuevo_ticket");
exit;
?>