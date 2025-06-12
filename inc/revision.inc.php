<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

$ticket = $_GET["ticket"];
$flujo = $_GET["flujo"];
$proceso = $_GET["proceso"];
$usuario = $_SESSION["usuario"];

include "conexion.inc.php";

// Obtener los datos de la solicitud
$sql = "SELECT * FROM solicitudes WHERE ticket = $ticket";
$res = mysqli_query($conexion, $sql);
$fila = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Revisión de Solicitud</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="w-full max-w-2xl bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-indigo-600 mb-6">🛠 Revisión de Solicitud de Mantenimiento</h2>

    <div class="mb-6 space-y-2 text-gray-700">
        <p><strong>📝 Descripción:</strong> <?= htmlspecialchars($fila["descripcion"]) ?></p>
        <p><strong>📍 Piso:</strong> <?= htmlspecialchars($fila["piso"]) ?></p>
        <p><strong>🔧 Tipo de Reparación:</strong> <?= htmlspecialchars($fila["tipo_reparacion"]) ?></p>
    </div>

    <form action="controlador.php" method="post" class="space-y-4">
        <input type="hidden" name="flujo" value="<?= $flujo ?>">
        <input type="hidden" name="proceso" value="<?= $proceso ?>">
        <input type="hidden" name="ticket" value="<?= $ticket ?>">
        <input type="hidden" name="usuario" value="<?= $usuario ?>">

        <div class="flex justify-end gap-4">
            <button type="submit" name="accion" value="Rechazar"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow">
                ❌ Rechazar
            </button>

            <button type="submit" name="accion" value="Aprobar"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow">
                ✅ Aprobar
            </button>
        </div>
    </form>
</div>
</body>
</html>
