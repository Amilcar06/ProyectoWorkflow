<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form'])) {
    $datos = $_POST['form'];
    $nombre_archivo = 'formularios.json';

    if (file_put_contents($nombre_archivo, $datos)) {
        echo 'Formulario guardado correctamente.';
    } else {
        echo 'Error al guardar el formulario.';
    }
} else {
    echo 'Datos inválidos.';
}
