<?php
$conn = new mysqli("localhost", "root", "", "workflow_db");
function iniciarEjecucion($flujo_id, $conn) {
    $stmt = $conn->prepare("INSERT INTO ejecuciones (flujo_id) VALUES (?)");
    $stmt->bind_param("i", $flujo_id);
    $stmt->execute();
    $ejecucion_id = $conn->insert_id;

    $pasos = $conn->query("SELECT * FROM pasos WHERE flujo_id = $flujo_id ORDER BY orden");
    while ($paso = $pasos->fetch_assoc()) {
        $conn->query("INSERT INTO tareas (ejecucion_id, paso_id) VALUES ($ejecucion_id, {$paso['id']})");
    }

    return $ejecucion_id;
}

function obtenerPasoActual($ejecucion_id, $conn) {
    $query = "SELECT t.id as tarea_id, p.nombre, p.orden, f.json_definicion
              FROM tareas t
              JOIN pasos p ON p.id = t.paso_id
              LEFT JOIN formularios f ON f.id = p.formulario_id
              WHERE t.ejecucion_id = $ejecucion_id AND t.estado = 'pendiente'
              ORDER BY p.orden ASC LIMIT 1";
    $res = $conn->query($query);
    return $res->fetch_assoc();
}

function marcarCompletado($tarea_id, $conn) {
    $conn->query("UPDATE tareas SET estado = 'completado', fecha_fin = NOW() WHERE id = $tarea_id");
}

function flujoFinalizado($ejecucion_id, $conn) {
    $conn->query("UPDATE ejecuciones SET estado='finalizado', fecha_fin = NOW() WHERE id = $ejecucion_id");
}

function obtenerProgreso($ejecucion_id, $conn) {
    return $conn->query("
        SELECT p.nombre, t.estado, p.orden
        FROM tareas t
        JOIN pasos p ON p.id = t.paso_id
        WHERE t.ejecucion_id = $ejecucion_id
        ORDER BY p.orden
    ");
}
