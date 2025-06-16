<?php
include "conexion.inc.php";

$nrotramite = $_GET["nrotramite"];
$flujo = $_GET["flujo"];
$proceso = $_GET["proceso"];
$usuario = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Rechazo de Solicitud</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-red-50 to-white min-h-screen flex items-center justify-center px-4">

<div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-red-100 transition-all">

    <!-- Icono y título -->
    <div class="flex items-center justify-center mb-6">
        <div class="bg-red-100 text-red-600 p-4 rounded-full">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
    </div>

    <h1 class="text-2xl font-extrabold text-center text-red-700 mb-4">Solicitud Rechazada</h1>
    <p class="text-center text-gray-600 mb-6">Esta solicitud ha sido <strong>rechazada por el supervisor</strong>. El empleado será notificado automáticamente.</p>

    <!-- Mensaje y botón -->
    <form action="controlador.php" method="post" class="space-y-6">

        <!-- Hidden fields -->
        <input type="hidden" name="flujo" value="<?= htmlspecialchars($flujo) ?>">
        <input type="hidden" name="proceso" value="<?= htmlspecialchars($proceso) ?>">
        <input type="hidden" name="nrotramite" value="<?= htmlspecialchars($nrotramite) ?>">
        <input type="hidden" name="usuario" value="<?= htmlspecialchars($usuario) ?>">

        <div class="text-sm text-gray-700 bg-red-50 border border-red-200 p-3 rounded-lg">
            Por favor, confirme que ha leído esta notificación para continuar con el flujo.
        </div>

        <button type="submit" name="accion" value="Siguiente"
                class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-5 rounded-lg shadow-md transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5 13l4 4L19 7"/>
            </svg>
            Aceptar y continuar
        </button>
    </form>

</div>
</body>
</html>
