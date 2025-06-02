<?php
include 'conexion.php';
include 'motor.php';

$conn = new mysqli("localhost", "root", "", "workflow_db");
$ejecucion_id = intval($_GET['id']);
$tarea = obtenerPasoActual($ejecucion_id, $conn);

if (!$tarea) {
    flujoFinalizado($ejecucion_id, $conn);
    echo "<h3>Flujo finalizado</h3>";
    exit;
}

// Mostrar barra de progreso
$progreso = obtenerProgreso($ejecucion_id, $conn);
?>

<h2>🛠 Progreso del Flujo</h2>
<ul>
    <?php while ($p = $progreso->fetch_assoc()): ?>
        <li>
            <?= $p['orden'] ?>. <?= htmlspecialchars($p['nombre']) ?> -
            <strong><?= strtoupper($p['estado']) ?></strong>
        </li>
    <?php endwhile; ?>
</ul>

<hr>

<h3>Paso actual: <?= htmlspecialchars($tarea['nombre']) ?></h3>

<form action="guardar_respuesta.php" method="POST">
    <?php
    $formulario = json_decode($tarea['json_definicion'], true);
    foreach ($formulario as $campo): ?>
        <label><?= $campo['label'] ?></label><br>
        <input type="<?= $campo['type'] ?>" name="<?= $campo['name'] ?>" required><br><br>
    <?php endforeach; ?>

    <input type="hidden" name="tarea_id" value="<?= $tarea['tarea_id'] ?>">
    <input type="hidden" name="ejecucion_id" value="<?= $ejecucion_id ?>">
    <button type="submit">➡ Siguiente paso</button>
</form>
