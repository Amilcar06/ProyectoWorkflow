<?php
$flujoArchivo = 'flujo.json';
$data = file_get_contents('php://input');
if ($data) {
    file_put_contents($flujoArchivo, $data);
    echo "Flujo guardado correctamente.";
} else {
    echo "No se recibieron datos.";
}
