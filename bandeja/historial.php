<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include "../conexion.inc.php";

$usuario = $_SESSION["usuario"] ?? '';
$nrotramite = $_GET['nrotramite'] ?? '';

if (empty($nrotramite)) {
    echo "Trámite no especificado.";
    exit();
}

// Obtener rol del usuario
$sql = "SELECT rol FROM usuarios WHERE usuario = '$usuario'";
$res = mysqli_query($conexion, $sql);
$rol = mysqli_fetch_assoc($res)['rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Historial de Trámite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-gray-100 min-h-screen">

<?php include "../utils/header.php"; ?>

<main class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center gap-2">
        <i class="fas fa-history"></i> Historial del Trámite #<?php echo $nrotramite; ?>
    </h2>

    <?php
    $sql = "
        SELECT fs.flujo, fs.proceso, fs.usuario, fs.fecha_inicio, fs.fecha_fin, fp.pantalla, fp.tipo, fp.rol
        FROM flujoseguimiento fs
        JOIN flujoproceso fp ON fs.flujo = fp.flujo AND fs.proceso = fp.proceso
        WHERE fs.nrotramite = '$nrotramite'
        ORDER BY fs.fecha_inicio ASC
    ";
    $res = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($res) > 0): ?>
        <div class="overflow-x-auto bg-white rounded shadow-md">
            <table class="min-w-full table-auto text-sm">
                <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-4 py-2">Flujo</th>
                    <th class="px-4 py-2">Proceso</th>
                    <th class="px-4 py-2">Pantalla</th>
                    <th class="px-4 py-2">Tipo</th>
                    <th class="px-4 py-2">Rol</th>
                    <th class="px-4 py-2">Usuario</th>
                    <th class="px-4 py-2">Inicio</th>
                    <th class="px-4 py-2">Fin</th>
                    <th class="px-4 py-2">Duración</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($fila = mysqli_fetch_assoc($res)):
                    $inicio = new DateTime($fila['fecha_inicio']);
                    $fin = $fila['fecha_fin'] ? new DateTime($fila['fecha_fin']) : null;
                    $duracion = $fin ? $inicio->diff($fin)->format('%H:%I:%S') : 'En curso';
                    ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-gray-700"><?php echo $fila['flujo']; ?></td>
                        <td class="px-4 py-2 font-medium text-gray-800"><?php echo $fila['proceso']; ?></td>
                        <td class="px-4 py-2 text-gray-700"><?php echo $fila['pantalla']; ?></td>
                        <td class="px-4 py-2 text-gray-700"><?php echo $fila['tipo']; ?></td>
                        <td class="px-4 py-2 text-gray-700"><?php echo $fila['rol']; ?></td>
                        <td class="px-4 py-2 text-gray-700"><?php echo $fila['usuario']; ?></td>
                        <td class="px-4 py-2 text-gray-600"><?php echo $fila['fecha_inicio']; ?></td>
                        <td class="px-4 py-2 text-gray-600">
                            <?php echo $fila['fecha_fin'] ?? '<span class="text-yellow-500">En curso</span>'; ?>
                        </td>
                        <td class="px-4 py-2 text-blue-700"><?php echo $duracion; ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-red-600 text-lg mt-10 text-center">No se encontró historial para el trámite #<?php echo $nrotramite; ?>.</p>
    <?php endif; ?>

    <div class="mt-6">
        <a href="salida.php"
           class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold transition">
            <i class="fas fa-arrow-left"></i> Volver a la Bandeja de Salida
        </a>
    </div>
</main>

</body>
</html>
