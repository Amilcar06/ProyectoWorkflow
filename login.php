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
    <title>Login - Mantenimiento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-bgLight min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-sm border border-primary">
    <h2 class="text-2xl font-bold text-primary mb-6 text-center">Ingreso al sistema</h2>

    <form method="POST" action="auth.php" class="space-y-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700">Usuario:</label>
            <input type="text" name="usuario" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700">Contraseña:</label>
            <input type="text" name="contrasena" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
        </div>

        <button type="submit" class="w-full bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition">
            Ingresar
        </button>
    </form>

    <?php if (isset($_GET['error'])): ?>
        <p class="text-red-600 mt-4 text-center font-semibold">Usuario no válido</p>
    <?php endif; ?>
</div>

</body>
</html>
