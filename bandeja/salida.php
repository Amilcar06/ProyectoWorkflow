<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include "../conexion.inc.php";

$usuario = $_SESSION["usuario"] ?? '';

// Obtener datos del usuario
$sql = "SELECT rol FROM usuarios WHERE usuario = '$usuario'";
$res = mysqli_query($conexion, $sql);
$rol = mysqli_fetch_assoc($res)["rol"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bandeja de Salida</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-gray-50 min-h-screen">

<?php include "../utils/header.php"; ?>

<main class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">
        📤 Bandeja de Salida - <?php echo $usuario; ?> (<?php echo $rol; ?>)
    </h2>

    <?php
    if ($rol === 'supervisor') {
        // Mostrar mantenimiento
        $consulta_mantenimiento = "
            SELECT DISTINCT fs.nrotramite, s.descripcion, s.estado, MAX(fs.fecha_fin) AS ultima_accion
            FROM flujoseguimiento fs
            JOIN solicitudes_mantenimiento s ON fs.nrotramite = s.nrotramite
            WHERE fs.usuario = '$usuario'
              AND fs.fecha_fin IS NOT NULL
              AND s.estado = 'finalizado'
            GROUP BY fs.nrotramite, s.descripcion, s.estado
            ORDER BY ultima_accion DESC
        ";

        // Mostrar vacaciones
        $consulta_vacaciones = "
            SELECT DISTINCT fs.nrotramite, s.motivo AS descripcion, s.estado, MAX(fs.fecha_fin) AS ultima_accion
            FROM flujoseguimiento fs
            JOIN solicitudes_vacaciones s ON fs.nrotramite = s.nrotramite
            WHERE fs.usuario = '$usuario'
              AND fs.fecha_fin IS NOT NULL
              AND s.estado = 'finalizado'
            GROUP BY fs.nrotramite, s.estado
            ORDER BY ultima_accion DESC
        ";

        echo "<h3 class='text-xl font-semibold mt-8 mb-2 text-gray-700'>🛠️ Solicitudes de Mantenimiento Finalizadas</h3>";
        mostrarTabla($conexion, $consulta_mantenimiento);

        echo "<h3 class='text-xl font-semibold mt-12 mb-2 text-gray-700'>🌴 Solicitudes de Vacaciones Finalizadas</h3>";
        mostrarTabla($conexion, $consulta_vacaciones);

    } elseif (in_array($rol, ['encargado', 'supervisor', 'tecnico'])) {
        $consulta = "
            SELECT DISTINCT fs.nrotramite, s.descripcion, s.estado, MAX(fs.fecha_fin) AS ultima_accion
            FROM flujoseguimiento fs
            JOIN solicitudes_mantenimiento s ON fs.nrotramite = s.nrotramite
            WHERE fs.usuario = '$usuario'
              AND fs.fecha_fin IS NOT NULL
              AND s.estado = 'finalizado'
            GROUP BY fs.nrotramite, s.descripcion, s.estado
            ORDER BY ultima_accion DESC
        ";
        mostrarTabla($conexion, $consulta);

    } elseif (in_array($rol, ['empleado', 'rrhh'])) {
        $consulta = "
            SELECT DISTINCT fs.nrotramite, s.motivo AS descripcion, s.estado, MAX(fs.fecha_fin) AS ultima_accion
            FROM flujoseguimiento fs
            JOIN solicitudes_vacaciones s ON fs.nrotramite = s.nrotramite
            WHERE fs.usuario = '$usuario'
              AND fs.fecha_fin IS NOT NULL
              AND s.estado = 'finalizado'
            GROUP BY fs.nrotramite, s.estado
            ORDER BY ultima_accion DESC
        ";
        mostrarTabla($conexion, $consulta);

    } else {
        echo "<p class='text-red-600 text-lg'>🚫 No tienes permisos para ver la bandeja de salida.</p>";
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
                        <th class="py-3 px-6 text-left uppercase text-sm tracking-wider">Nro Trámite</th>
                        <th class="py-3 px-6 text-left uppercase text-sm tracking-wider">Descripción</th>
                        <th class="py-3 px-6 text-left uppercase text-sm tracking-wider">Estado</th>
                        <th class="py-3 px-6 text-left uppercase text-sm tracking-wider">Última Acción</th>
                        <th class="py-3 px-6 text-left uppercase text-sm tracking-wider">Historial</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($fila = mysqli_fetch_array($res)): ?>
                        <tr class="border-b hover:bg-blue-50">
                            <td class="py-3 px-6 font-medium text-gray-800"><?php echo $fila['nrotramite']; ?></td>
                            <td class="py-3 px-6 text-gray-700"><?php echo $fila['descripcion']; ?></td>
                            <td class="py-3 px-6 text-green-600 font-semibold"><?php echo $fila['estado']; ?></td>
                            <td class="py-3 px-6 text-gray-600"><?php echo $fila['ultima_accion']; ?></td>
                            <td class="py-3 px-6">
                                <a href="historial.php?nrotramite=<?php echo $fila['nrotramite']; ?>"
                                   class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-semibold transition">
                                    <i class="fas fa-history"></i> Ver historial
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
