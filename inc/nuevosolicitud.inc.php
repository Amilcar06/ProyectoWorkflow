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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Solicitud de Mantenimiento</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="w-full max-w-xl bg-white p-6 rounded-lg shadow-md">

    <h2 class="text-2xl font-bold text-indigo-600 mb-6">📝 Nueva Solicitud de Mantenimiento</h2>

    <form action="controlador.php" method="post" class="space-y-4">
        <input type="hidden" name="flujo" value="<?= $flujo ?>">
        <input type="hidden" name="proceso" value="<?= $proceso ?>">
        <input type="hidden" name="ticket" value="<?= $ticket ?>">
        <input type="hidden" name="usuario" value="<?= $usuario ?>">

        <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Describa el problema:</label>
            <textarea name="descripcion" id="descripcion" rows="5" required
                      class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500 resize-none"></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" name="accion" value="Siguiente"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded shadow">
                ➡ Siguiente
            </button>
        </div>
    </form>
</div>
</body>
</html>
