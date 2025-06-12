<?php
session_start();
include("conexion.inc.php");

$usuario = $_POST['usuario'];
$rol = $_POST['rol'];

$query = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND rol = '$rol'";
$result = mysqli_query($conexion, $query);

if (mysqli_num_rows($result) == 1) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['rol'] = $rol;
    header("Location: index.php");
} else {
    header("Location: login.php?error=1");
}
?>
