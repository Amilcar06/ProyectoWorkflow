<?php
include "conexion.inc.php";

$nrotramite = $_GET["nrotramite"];
$flujo = $_GET["flujo"];
$proceso = $_GET["proceso"];
$usuario = $_SESSION["usuario"];

// Obtener datos de la solicitud
$sql = "SELECT * FROM solicitudes_vacaciones WHERE nrotramite = $nrotramite";
$resultado = mysqli_query($conexion, $sql);
$solicitud = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisión de Solicitud</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-green-600 mb-6">🔍 Revisión de Solicitud</h2>
    <p><strong>Empleado:</strong> <?= htmlspecialchars($solicitud['empleado_usuario']) ?></p>
    <p><strong>Desde:</strong> <?= htmlspecialchars($solicitud['fecha_desde']) ?></p>
    <p><strong>Hasta:</strong> <?= htmlspecialchars($solicitud['fecha_hasta']) ?></p>
    <p><strong>Motivo:</strong> <?= nl2br(htmlspecialchars($solicitud['motivo'])) ?></p>
    
    <form action="controlador.php" method="post" class="mt-6 space-y-4">
        <input type="hidden" name="flujo" value="<?= htmlspecialchars($flujo) ?>">
        <input type="hidden" name="proceso" value="<?= htmlspecialchars($proceso) ?>">
        <input type="hidden" name="nrotramite" value="<?= htmlspecialchars($nrotramite) ?>">
        <input type="hidden" name="usuario" value="<?= htmlspecialchars($usuario) ?>">
        
        <button type="submit" name="accion" value="Siguiente"
                class="bg-green-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow">
            Siguiente
        </button>
    </form>
</div>
</body>
</html>
