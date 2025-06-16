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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechazar Solicitud</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
<div class="w-full max-w-lg bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-red-600 mb-6">❌ Solicitud Rechazada</h2>
    <p>El supervisor ha rechazado esta solicitud. Se notificará al empleado.</p>
    <a href="../bandeja/entrada.php" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded shadow">
        🏠 Volver a la Bandeja
    </a>
</div>
</body>
</html>
