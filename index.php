<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Sistema de Mantenimiento</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center font-sans">

<div class="bg-white shadow-2xl rounded-3xl p-10 max-w-3xl w-full">
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-bold text-blue-700 mb-1">👋 Bienvenido, <span class="text-blue-900"><?= htmlspecialchars($usuario) ?></span></h1>
        <p class="text-gray-600">Rol asignado: <span class="font-medium text-purple-600"><?= htmlspecialchars($rol) ?></span></p>
    </div>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-5 mt-8 text-center">
        <?php if ($rol === 'empleado'): ?>
            <a href="nuevo_ticket.php?flujo=F2"
               class="group block bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-5 py-4 shadow-md transition-transform hover:-translate-y-1">
                <div class="text-xl mb-1">🛠️</div>
                <div class="font-semibold">Solicitar Mantenimiento</div>
            </a>

            <a href="nuevo_ticket.php?flujo=F3"
               class="group block bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl px-5 py-4 shadow-md transition-transform hover:-translate-y-1">
                <div class="text-xl mb-1">🏖️</div>
                <div class="font-semibold">Solicitar Vacación</div>
            </a>
        <?php endif; ?>

        <a href="bandeja/entrada.php"
           class="group block bg-green-600 hover:bg-green-700 text-white rounded-xl px-5 py-4 shadow-md transition-transform hover:-translate-y-1">
            <div class="text-xl mb-1">📥</div>
            <div class="font-semibold">Bandeja de Entrada</div>
        </a>

        <a href="bandeja/salida.php"
           class="group block bg-gray-700 hover:bg-gray-800 text-white rounded-xl px-5 py-4 shadow-md transition-transform hover:-translate-y-1">
            <div class="text-xl mb-1">📤</div>
            <div class="font-semibold">Bandeja de Salida</div>
        </a>

        <a href="logout.php"
           class="group block bg-red-600 hover:bg-red-700 text-white rounded-xl px-5 py-4 shadow-md transition-transform hover:-translate-y-1 col-span-full sm:col-span-2 md:col-span-1">
            <div class="text-xl mb-1">🚪</div>
            <div class="font-semibold">Cerrar Sesión</div>
        </a>
    </div>
</div>

</body>
</html>
