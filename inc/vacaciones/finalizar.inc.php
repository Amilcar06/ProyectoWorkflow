<?php
include "conexion.inc.php";

session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

$nrotramite = $_GET["nrotramite"];
$flujo = $_GET["flujo"];
$proceso = $_GET["proceso"];
$usuario = $_SESSION["usuario"];

// Obtener detalles de la solicitud de vacaciones
$sql = "SELECT * FROM solicitudes_vacaciones WHERE nrotramite = $nrotramite";
$res = mysqli_query($conexion, $sql);
$fila = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Solicitud de Vacaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl">
    <h2 class="text-2xl font-bold text-green-600 mb-6">🏁 Finalizar Solicitud de Vacaciones</h2>

    <div class="text-gray-800 space-y-2 mb-6">
        <p><strong>👤 Empleado:</strong> <?= htmlspecialchars($fila["empleado_usuario"]) ?></p>
        <p><strong>📅 Fecha desde:</strong> <?= htmlspecialchars($fila["fecha_desde"]) ?></p>
        <p><strong>📅 Fecha hasta:</strong> <?= htmlspecialchars($fila["fecha_hasta"]) ?></p>
        <p><strong>📝 Motivo:</strong> <?= nl2br(htmlspecialchars($fila["motivo"])) ?></p>
        <p><strong>📌 Estado actual:</strong> <?= ucfirst(htmlspecialchars($fila["estado"])) ?></p>
    </div>

    <form action="controlador.php" method="post" class="space-y-4">
        <input type="hidden" name="flujo" value="<?= $flujo ?>">
        <input type="hidden" name="proceso" value="<?= $proceso ?>">
        <input type="hidden" name="nrotramite" value="<?= $nrotramite ?>">
        <input type="hidden" name="usuario" value="<?= $usuario ?>">

        <p class="text-gray-700 font-medium">¿Confirma que esta solicitud ha sido completada y desea finalizarla?</p>

        <div class="flex justify-end">
            <button type="submit" name="accion" value="Siguiente"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow">
                ✅ Finalizar Solicitud
            </button>
        </div>
    </form>
</div>
</body>
</html>
