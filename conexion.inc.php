<?php
$host = 'localhost';
$usuario = 'root';        // Cambia esto si usas otro usuario
$password = '';           // Cambia esto si tienes contraseña
$base_datos = 'mantenimiento';  // Cambia por el nombre de tu base de datos

$conexion = new mysqli($host, $usuario, $password, $base_datos);

// Verifica si hubo error
if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

// Opcional: establecer juego de caracteres
$conexion->set_charset("utf8");
?>
