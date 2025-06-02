<?php
$host = "localhost";
$dbname = "workflow_db";
$user = "root";
$password = ""; // XAMPP usualmente no tiene contraseña por defecto

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
