<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Denegado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-red-100 to-red-200 flex items-center justify-center font-sans">

<div class="bg-white shadow-xl rounded-2xl p-10 max-w-md w-full text-center animate-fade-in">
    <div class="flex justify-center mb-6">
        <div class="bg-red-100 text-red-600 rounded-full p-4 shadow-md">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M18.364 5.636l-1.414 1.414M5.636 5.636l1.414 1.414M12 9v4m0 4h.01M21 12A9 9 0 1 1 3 12a9 9 0 0 1 18 0z"/>
            </svg>
        </div>
    </div>
    <h1 class="text-3xl font-semibold text-red-700 mb-2">Acceso Denegado</h1>
    <p class="text-gray-600 mb-6">No tienes permisos para ver esta sección del sistema. Contacta al administrador si crees que es un error.</p>
    <a href="bandeja/entrada.php"
       class="inline-flex items-center bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition-all duration-200 shadow-md">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a la bandeja
    </a>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.4s ease-out;
    }
</style>

</body>
</html>
