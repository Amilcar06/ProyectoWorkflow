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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ubicación y Tipo de Reparación</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="w-full max-w-xl bg-white p-6 rounded-lg shadow-md">

    <h2 class="text-2xl font-bold text-indigo-600 mb-6">🏢 Ubicación y Tipo de Reparación</h2>

    <form action="controlador.php" method="post" class="space-y-5">
        <input type="hidden" name="flujo" value="<?= $flujo ?>">
        <input type="hidden" name="proceso" value="<?= $proceso ?>">
        <input type="hidden" name="nrotramite" value="<?= $nrotramite ?>">
        <input type="hidden" name="usuario" value="<?= $usuario ?>">

        <div>
            <label for="piso" class="block text-sm font-medium text-gray-700 mb-1">Seleccione el piso:</label>
            <select name="piso" id="piso" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                <option value="">-- Seleccione --</option>
                <option value="Planta Baja">Planta Baja</option>
                <option value="1er Piso">1er Piso</option>
                <option value="2do Piso">2do Piso</option>
                <option value="3er Piso">3er Piso</option>
            </select>
        </div>

        <div>
            <label for="tipo_reparacion" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Reparación:</label>
            <select name="tipo_reparacion" id="tipo_reparacion" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:ring-indigo-200 focus:border-indigo-500">
                <option value="">-- Seleccione --</option>
                <option value="Eléctrico">Eléctrico</option>
                <option value="Plomería">Plomería</option>
                <option value="Carpintería">Carpintería</option>
                <option value="Otro">Otro</option>
            </select>
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
