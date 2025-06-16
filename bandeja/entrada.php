<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include "../conexion.inc.php";
$usuario = $_SESSION["usuario"] ?? '';

$sql = "SELECT rol FROM usuarios WHERE usuario = '$usuario'";
$res = mysqli_query($conexion, $sql);
$rol = mysqli_fetch_assoc($res)["rol"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bandeja de Entrada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen font-sans">

<?php include "../utils/header.php"; ?>

<main class="max-w-6xl mx-auto px-6 py-10">
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-indigo-700">📥 Bandeja de Entrada</h2>
        <p class="text-gray-600 mt-1 text-lg">Bienvenido <span class="font-semibold text-blue-700"><?= $usuario ?></span> - Rol: <span class="font-semibold text-purple-700"><?= $rol ?></span></p>
    </div>

    <?php
    if ($rol === 'supervisor' || $rol === 'empleado') {
        // Mostrar mantenimiento
        $consulta_mantenimiento = "
            SELECT fs.nrotramite, fs.proceso, fs.flujo
                    FROM flujoseguimiento fs
                    WHERE fs.usuario = '$usuario'
                    AND fs.fecha_fin IS NULL
                    AND fs.flujo = 'F2'
                    ORDER BY fs.nrotramite;
        ";

        // Mostrar vacaciones
        $consulta_vacaciones = "
            SELECT fs.nrotramite, fs.proceso, fs.flujo
                    FROM flujoseguimiento fs
                    WHERE fs.usuario = '$usuario'
                    AND fs.fecha_fin IS NULL
                    AND fs.flujo = 'F3'
                    ORDER BY fs.nrotramite;
        ";

        echo "<h3 class='text-xl font-semibold mt-8 mb-2 text-gray-700'>🛠️ Solicitudes de Mantenimiento Iniciadas</h3>";
        mostrarTabla($conexion, $consulta_mantenimiento);

        echo "<h3 class='text-xl font-semibold mt-12 mb-2 text-gray-700'>🌴 Solicitudes de Vacaciones Iniciadas</h3>";
        mostrarTabla($conexion, $consulta_vacaciones);

    } elseif ($rol === 'tecnico') {
        $consulta = "
            SELECT fs.nrotramite, fs.proceso, fs.flujo
                    FROM flujoseguimiento fs
                    WHERE fs.usuario = '$usuario'
                    AND fs.fecha_fin IS NULL
                    AND fs.flujo = 'F2'
                    ORDER BY fs.nrotramite;
        ";
        mostrarTabla($conexion, $consulta);

    } elseif ($rol ==='rrhh') {
        $consulta = "
            SELECT fs.nrotramite, fs.proceso, fs.flujo
                    FROM flujoseguimiento fs
                    WHERE fs.usuario = '$usuario'
                    AND fs.fecha_fin IS NULL
                    AND fs.flujo = 'F3'
                    ORDER BY fs.nrotramite;
        ";
        mostrarTabla($conexion, $consulta);

    } else {
        echo "<p class='text-red-600 text-lg'>🚫 No tienes permisos para ver la bandeja de entrada.</p>";
        exit;
    }
    // Función para mostrar tabla
    function mostrarTabla($conexion, $consulta) {
        $res = mysqli_query($conexion, $consulta);

        if (mysqli_num_rows($res) > 0): ?>
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full bg-white rounded-lg shadow-md">
                    <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wide">Ticket</th>
                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wide">Proceso</th>
                        <th class="px-6 py-3 text-left text-sm font-medium uppercase tracking-wide">Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($fila = mysqli_fetch_array($res)): ?>
                        <tr class="border-b hover:bg-blue-50">
                            <td class="py-3 px-6 font-medium text-gray-800"><?php echo $fila['nrotramite']; ?></td>
                            <td class="py-3 px-6 text-gray-700"><?php echo $fila['proceso']; ?></td>
                            <td class="py-3 px-6">
                                <a href="../inicial.php?flujo=<?php echo $fila['flujo']; ?>&proceso=<?php echo $fila['proceso']; ?>&nrotramite=<?php echo $fila['nrotramite']; ?>"
                                   class="inline-flex items-center gap-2 bg-indigo-100 text-indigo-700 px-3 py-2 rounded-lg font-semibold hover:bg-indigo-200 transition">
                                    <i class="fas fa-arrow-circle-right text-indigo-600"></i> Abrir Formulario
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-600 text-lg text-center mt-4 flex items-center justify-center gap-2">
                <span>📭</span> No hay solicitudes finalizadas para mostrar.
            </p>
        <?php endif;
    }

    ?>
</main>

</body>
</html>
