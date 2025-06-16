<?php
session_start();
include "conexion.inc.php";

$nrotramite = $_GET["nrotramite"];
$flujo = $_GET["flujo"];
$proceso = $_GET["proceso"];
$usuario = $_SESSION["usuario"];

// Obtener detalles de la solicitud
$sql = "SELECT * FROM solicitudes_mantenimiento WHERE nrotramite = $nrotramite";
$res = mysqli_query($conexion, $sql);
$fila = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Aprobar Solicitud</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-white min-h-screen flex items-center justify-center">

<div class="w-full max-w-xl bg-white p-8 rounded-2xl shadow-xl border border-gray-200 transition-all">

    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-blue-700 mb-2">📄 Revisión de Solicitud</h1>
        <p class="text-gray-600 text-sm">Trámite: <strong>#<?= htmlspecialchars($nrotramite) ?></strong></p>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg border mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">🛠️ Detalles del Mantenimiento</h2>
        <ul class="text-sm text-gray-700 space-y-1">
            <li><strong>Solicitante:</strong> <?= htmlspecialchars($usuario) ?></li>
            <li><strong>Área:</strong> <?= htmlspecialchars('Medicina') ?></li>
        </ul>
    </div>

    <form action="controlador.php" method="post" class="flex flex-col gap-4">
        <!-- Hidden Inputs -->
        <input type="hidden" name="flujo" value="<?= htmlspecialchars($flujo) ?>">
        <input type="hidden" name="proceso" value="<?= htmlspecialchars($proceso) ?>">
        <input type="hidden" name="nrotramite" value="<?= htmlspecialchars($nrotramite) ?>">
        <input type="hidden" name="usuario" value="<?= htmlspecialchars($usuario) ?>">

        <div class="flex gap-4">
            <button type="submit" name="respuesta" value="si"
                    class="flex-1 inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white py-2.5 px-5 rounded-lg font-semibold shadow transition-all">
                <i class="fas fa-check-circle"></i> Aprobar
            </button>

            <button type="submit" name="respuesta" value="no"
                    class="flex-1 inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white py-2.5 px-5 rounded-lg font-semibold shadow transition-all">
                <i class="fas fa-times-circle"></i> Rechazar
            </button>
        </div>
    </form>
</div>

<!-- Icon CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
