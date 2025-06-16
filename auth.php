<?php
session_start();
include("conexion.inc.php");

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena']; // corregido

// Usar consulta preparada para evitar inyección SQL
$stmt = $conexion->prepare("SELECT usuario, contrasena, rol FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Comparar directamente (sin password_verify porque no hay hash)
    if ($contrasena === $row['contrasena']) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = $row['rol'];
        header("Location: index.php");
        exit;
    } else {
        header("Location: login.php?error=1");  // Contraseña incorrecta
        exit;
    }
} else {
    header("Location: login.php?error=1");  // Usuario no encontrado
    exit;
}
?>
