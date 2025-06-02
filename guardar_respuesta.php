<?php
include 'conexion.php';
include 'motor.php';

$conn = new mysqli("localhost", "root", "", "workflow_db");

$tarea_id = $_POST['tarea_id'];
$ejecucion_id = $_POST['ejecucion_id'];

unset($_POST['tarea_id'], $_POST['ejecucion_id']);
$datos = json_encode($_POST);

$conn->query("INSERT INTO respuestas (tarea_id, datos_json) VALUES ($tarea_id, '$datos')");
marcarCompletado($tarea_id, $conn);

header("Location: ejecucion_view.php?id=$ejecucion_id");
exit;
