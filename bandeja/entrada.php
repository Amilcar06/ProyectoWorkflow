<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include "../conexion.inc.php";
$usuario = $_SESSION["usuario"] ?? '';

// Obtener el rol del usuario
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-gray-50 min-h-screen">

<?php include "../utils/header.php"; ?>

<main class="max-w-6xl mx-auto p-6">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">
        📥 Bandeja de Entrada - <?php echo $usuario; ?> (<?php echo $rol; ?>)
    </h2>

    <?php
    // Obtener tickets pendientes del usuario
    $sql = "
        SELECT fs.nrotramite, fs.proceso, fs.flujo
        FROM flujoseguimiento fs
        WHERE fs.usuario = '$usuario'
          AND fs.fecha_fin IS NULL
        ORDER BY fs.nrotramite;
    ";
    $res = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($res) > 0): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md">
                <thead class="bg-indigo-600 text-white">
                <tr>
                    <th class="py-3 px-6 text-left uppercase text-sm tracking-wider">Ticket</th>
                    <th class="py-3 px-6 text-left uppercase text-sm tracking-wider">Proceso Actual</th>
                    <th class="py-3 px-6 text-left uppercase text-sm tracking-wider">Acción</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($fila = mysqli_fetch_array($res)):
                    $flujo = $fila['flujo'];
                    $proceso = $fila['proceso'];
                    $nrotramite = $fila['nrotramite'];
                    ?>
                    <tr class="border-b hover:bg-indigo-50">
                        <td class="py-3 px-6 font-medium text-gray-800"><?php echo $nrotramite; ?></td>
                        <td class="py-3 px-6 text-gray-700"><?php echo $proceso; ?></td>
                        <td class="py-3 px-6">
                            <a href="../inicial.php?flujo=<?php echo $flujo; ?>&proceso=<?php echo $proceso; ?>&nrotramite=<?php echo $nrotramite; ?>"
                               class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-semibold transition">
                                <i class="fas fa-arrow-right"></i> Ir al formulario
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-gray-600 text-lg text-center mt-10 flex items-center justify-center gap-2">
            <span>📭</span> No tienes procesos pendientes en este momento.
        </p>
    <?php endif; ?>
</main>

</body>
</html>
