<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include "../conexion.inc.php";
$ticket = $_GET["ticket"] ?? 0;
$usuario = $_SESSION["usuario"] ?? '';

include "../utils/header.php";

// Obtener historial
$sql = "
SELECT f.flujo, f.proceso, p.pantalla, p.rol, f.usuario, f.fechainicial, f.fechafinal
FROM flujousuario f
JOIN flujoproceso p ON f.flujo = p.flujo AND f.proceso = p.proceso
WHERE f.ticket = $ticket
ORDER BY f.fechainicial
";
$res = mysqli_query($conexion, $sql);

$historial = [];
while ($fila = mysqli_fetch_array($res)) {
    $historial[] = $fila;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Ticket #<?= $ticket ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">

<main class="max-w-5xl mx-auto p-6">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">
        📜 Historial del Ticket #<?= $ticket ?>
    </h2>

    <?php if (count($historial) > 0):
        $ultimo = end($historial);
        $estado = "-";
        if ($ultimo['fechafinal'] == null) {
            $estado = "🟡 En Proceso";
        } elseif (strtolower($ultimo['pantalla']) === "rechazado") {
            $estado = "❌ Rechazado";
        } elseif (strtolower($ultimo['pantalla']) === "finalizar") {
            $estado = "✅ Finalizado";
        } else {
            $estado = "🟢 En Ejecución";
        }
        ?>
        <div class="bg-white p-4 rounded shadow border-l-4 border-indigo-500 mb-6">
            <p class="text-lg"><strong>Estado actual:</strong> <?= $estado ?></p>
            <p class="text-lg"><strong>Último proceso:</strong> <?= $ultimo['pantalla'] ?> (<?= $ultimo['rol'] ?>)</p>
            <p class="text-lg"><strong>Ejecutado por:</strong> <?= $ultimo['usuario'] ?></p>
            <p class="text-lg"><strong>Fecha:</strong> <?= $ultimo['fechainicial'] ?></p>
        </div>
    <?php else: ?>
        <p class="text-gray-600">No se encontró historial para este ticket.</p>
    <?php endif; ?>

    <?php if (count($historial) > 0): ?>
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full text-sm text-left text-gray-700">
                <thead class="bg-indigo-600 text-white uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Flujo</th>
                    <th class="px-6 py-3">Proceso</th>
                    <th class="px-6 py-3">Pantalla</th>
                    <th class="px-6 py-3">Rol</th>
                    <th class="px-6 py-3">Usuario</th>
                    <th class="px-6 py-3">Fecha Inicio</th>
                    <th class="px-6 py-3">Fecha Fin</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <?php foreach ($historial as $fila): ?>
                    <tr class="hover:bg-indigo-50">
                        <td class="px-6 py-4"><?= $fila['flujo'] ?></td>
                        <td class="px-6 py-4"><?= $fila['proceso'] ?></td>
                        <td class="px-6 py-4"><?= $fila['pantalla'] ?></td>
                        <td class="px-6 py-4"><?= $fila['rol'] ?></td>
                        <td class="px-6 py-4"><?= $fila['usuario'] ?></td>
                        <td class="px-6 py-4"><?= $fila['fechainicial'] ?></td>
                        <td class="px-6 py-4"><?= $fila['fechafinal'] ?? '—' ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="mt-6">
        <a href="salida.php" class="inline-flex items-center bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded transition">
            ⬅ Volver a la bandeja de salida
        </a>
    </div>
</main>

</body>
</html>
