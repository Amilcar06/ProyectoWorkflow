<?php
include "conexion.inc.php";

$nrotramite = $_GET["nrotramite"] ?? '';
$flujo = $_GET["flujo"] ?? 'F1';
$proceso = $_GET["proceso"] ?? 'P1';
$usuario = $_SESSION["usuario"] ?? '';

if (!$usuario) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Solicitud de Vacaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-md">

    <h2 class="text-2xl font-bold text-indigo-600 mb-6">🏖 Solicitud de Vacaciones</h2>

    <form action="controlador.php" method="post" class="space-y-4">
        <!-- Campos ocultos para mantener el flujo -->
        <input type="hidden" name="flujo" value="<?= htmlspecialchars($flujo) ?>" />
        <input type="hidden" name="proceso" value="<?= htmlspecialchars($proceso) ?>" />
        <input type="hidden" name="nrotramite" value="<?= htmlspecialchars($nrotramite) ?>" />
        <input type="hidden" name="usuario" value="<?= htmlspecialchars($usuario) ?>" />

        

        <!-- Fecha de inicio de vacaciones -->
        <div>
            <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-1">Fecha de inicio:</label>
            <input
                type="date" name="fecha_desde" id="fecha_desde" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500"
            />
        </div>

        <!-- Fecha de fin de vacaciones -->
        <div>
            <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-1">Fecha de fin:</label>
            <input
                type="date" name="fecha_hasta" id="fecha_hasta" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500"
            />
        </div>

        <!-- Motivo de la solicitud -->
        <div>
            <label for="motivo" class="block text-sm font-medium text-gray-700 mb-1">Motivo:</label>
            <textarea name="motivo" id="motivo" rows="4" required
                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500 resize-none"
            ></textarea>
        </div>

        <!-- Botón para enviar la solicitud -->
        <div class="flex justify-end">
            <button
                type="submit" name="accion" value="Siguiente"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded shadow"
            >
                ➡ Siguiente
            </button>
        </div>
    </form>
</div>
</body>
</html>
