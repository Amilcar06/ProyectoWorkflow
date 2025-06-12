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

// Obtener detalles de la solicitud
$sql = "SELECT * FROM solicitudes WHERE ticket = $ticket";
$res = mysqli_query($conexion, $sql);
$fila = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Solicitud</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl">
    <h2 class="text-2xl font-bold text-green-600 mb-6">✅ Finalización de la Solicitud</h2>

    <div class="text-gray-800 space-y-2 mb-6">
        <p><strong>📝 Descripción:</strong> <?= htmlspecialchars($fila["descripcion"]) ?></p>
        <p><strong>📍 Ubicación:</strong> <?= htmlspecialchars($fila["piso"]) ?></p>
        <p><strong>🔧 Tipo de Reparación:</strong> <?= htmlspecialchars($fila["tipo_reparacion"]) ?></p>
        <p><strong>📌 Estado actual:</strong> <?= ucfirst(htmlspecialchars($fila["estado"])) ?></p>

        <?php if (!empty($fila["observaciones"])): ?>
            <p><strong>🗒 Observaciones:</strong> <?= htmlspecialchars($fila["observaciones"]) ?></p>
        <?php endif; ?>
    </div>

    <form action="controlador.php" method="post" class="space-y-4">
        <input type="hidden" name="flujo" value="<?= $flujo ?>">
        <input type="hidden" name="proceso" value="<?= $proceso ?>">
        <input type="hidden" name="ticket" value="<?= $ticket ?>">
        <input type="hidden" name="usuario" value="<?= $usuario ?>">

        <p class="text-gray-700 font-medium">¿Confirma que esta solicitud está finalizada y desea cerrar el proceso?</p>

        <div class="flex justify-end">
            <button type="submit" name="accion" value="Siguiente"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow">
                Finalizar Solicitud
            </button>
        </div>
    </form>
</div>
</body>
</html>
