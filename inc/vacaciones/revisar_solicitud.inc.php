<?php
session_start();
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Revisión de Vacaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-50 to-white min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl border border-gray-200 p-8 transition-all">

    <!-- Header -->
    <div class="mb-6 border-b pb-4">
        <h1 class="text-3xl font-bold text-green-700 flex items-center gap-2">
            🌴 Revisión de Vacaciones
        </h1>
        <p class="text-sm text-gray-500 mt-1">Verifica los datos antes de continuar con el trámite.</p>
    </div>

    <!-- Información de la solicitud -->
    <div class="space-y-4 text-gray-700">
        <div class="flex items-center gap-2">
            <span class="font-semibold w-28">👤 Empleado:</span>
            <span><?= htmlspecialchars($solicitud['empleado_usuario']) ?></span>
        </div>
        <div class="flex items-center gap-2">
            <span class="font-semibold w-28">📅 Desde:</span>
            <span><?= htmlspecialchars($solicitud['fecha_desde']) ?></span>
        </div>
        <div class="flex items-center gap-2">
            <span class="font-semibold w-28">📅 Hasta:</span>
            <span><?= htmlspecialchars($solicitud['fecha_hasta']) ?></span>
        </div>
        <div class="flex items-start gap-2">
            <span class="font-semibold w-28">📝 Motivo:</span>
            <p class="text-sm text-gray-800 whitespace-pre-line"><?= htmlspecialchars($solicitud['motivo']) ?></p>
        </div>
    </div>

    <!-- Formulario de acción -->
    <form action="controlador.php" method="post" class="mt-8">
        <input type="hidden" name="flujo" value="<?= htmlspecialchars($flujo) ?>">
        <input type="hidden" name="proceso" value="<?= htmlspecialchars($proceso) ?>">
        <input type="hidden" name="nrotramite" value="<?= htmlspecialchars($nrotramite) ?>">
        <input type="hidden" name="usuario" value="<?= htmlspecialchars($usuario) ?>">

        <button type="submit" name="accion" value="Siguiente"
                class="w-full py-3 px-6 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow transition-all text-lg">
            ➡️ Continuar con Trámite
        </button>
    </form>
</div>
</body>
</html>
