<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Sistema de Mantenimiento</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-blue-700 mb-4">👋 Bienvenido</h2>
    <p class="text-gray-700 mb-6">
        Usuario: <strong class="text-blue-600"><?php echo $_SESSION['usuario']; ?></strong><br>
        Rol: <strong class="text-purple-600"><?php echo $_SESSION['rol']; ?></strong>
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4">
        <a href="nuevo_ticket.php"
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition">
            ➕ Nueva Solicitud
        </a>

        <a href="bandeja/entrada.php"
           class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow transition">
            📥 Bandeja de Entrada
        </a>

        <a href="bandeja/salida.php"
           class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded shadow transition">
            📤 Bandeja de Salida
        </a>

        <a href="logout.php"
           class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition">
            🚪 Cerrar Sesión
        </a>
    </div>
</div>

</body>
</html>
