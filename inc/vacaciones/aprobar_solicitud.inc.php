<?php
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobar Solicitud</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-blue-600 mb-6">✅ Aprobar o Rechazar</h2>
    <form action="controlador.php" method="post" class="space-y-4">
        <input type="hidden" name="flujo" value="<?= htmlspecialchars($flujo) ?>">
        <input type="hidden" name="proceso" value="<?= htmlspecialchars($proceso) ?>">
        <input type="hidden" name="nrotramite" value="<?= htmlspecialchars($nrotramite) ?>">
        <input type="hidden" name="usuario" value="<?= htmlspecialchars($usuario) ?>">
        
        <button type="submit" name="respuesta" value="si"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow">
            ✅ Aprobar
        </button>
        <button type="submit" name="respuesta" value="no"
                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow">
            ❌ Rechazar
        </button>
    </form>
</div>
</body>
</html>
