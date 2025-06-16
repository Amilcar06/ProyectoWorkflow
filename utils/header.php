<?php
if (!isset($_SESSION)) session_start();
?>

<div class="bg-white border-b border-blue-600 shadow-md px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
    <div class="text-xl font-bold text-blue-700 mb-2 sm:mb-0">
        🛠️ Sistema de Mantenimiento
    </div>
    <div class="text-sm text-gray-800 space-x-4">
        <span>👤 Usuario: <strong class="text-blue-600"><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></span>
        <a href="../index.php" class="text-white bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md transition">🏠 Inicio</a>
        <a href="../logout.php" class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md transition">🔒 Cerrar sesión</a>
    </div>
</div>