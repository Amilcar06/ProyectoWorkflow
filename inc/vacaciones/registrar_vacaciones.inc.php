<?php
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include "conexion.inc.php";
$nrotramite = $_GET["nrotramite"];
$flujo = $_GET["flujo"];
$proceso = $_GET["proceso"];
$usuario = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Vacaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-purple-600 mb-6">📋 Registrar Vacaciones</h2>
    <p class="mb-4">Finaliza este proceso para registrar las vacaciones como "aprobadas".</p>
    <form action="controlador.php" method="POST" class="flex justify-center">
        <input type="hidden" name="flujo" value="<?= $flujo ?>">
        <input type="hidden" name="proceso" value="<?= $proceso ?>">
        <input type="hidden" name="nrotramite" value="<?= $nrotramite ?>">
        <input type="hidden" name="usuario" value="<?= $usuario ?>">
        <button type="submit" name="accion" value="Siguiente"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow">
            ✔ Finalizar Registro
        </button>
    </form>
</div>
</body>
</html>
