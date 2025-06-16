<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: inicial.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema de Mantenimiento</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 min-h-screen flex items-center justify-center">

<div class="bg-white border border-blue-200 shadow-2xl rounded-xl p-8 w-full max-w-md animate-fade-in">
    <div class="text-center mb-6">
        <h1 class="text-3xl font-extrabold text-blue-700">🔐 Ingreso al Sistema</h1>
        <p class="text-gray-500 mt-2">Accede con tus credenciales</p>
    </div>

    <form method="POST" action="auth.php" class="space-y-5">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
            <input type="text" name="usuario" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-blue-500 transition">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
            <input type="password" name="contrasena" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-blue-500 transition">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-md shadow transition">
            Ingresar
        </button>
    </form>

    <?php if (isset($_GET['error'])): ?>
        <p class="text-red-600 mt-4 text-center font-semibold">⚠️ Usuario o contraseña incorrectos</p>
    <?php endif; ?>
</div>

<!-- Animación fade-in simple -->
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.6s ease-out both;
    }
</style>

</body>
</html>
