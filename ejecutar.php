<?php

include 'conexion.php';
include 'motor.php';

$conn = new mysqli("localhost", "root", "", "workflow_db");
$flujo_id = $_GET['id'];
$ejecucion_id = iniciarEjecucion($flujo_id, $conn);

header("Location: ejecucion_view.php?id=$ejecucion_id");
exit;
