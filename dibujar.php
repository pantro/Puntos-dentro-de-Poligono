<?php
// Crear una imágen en blanco
$imagen = imagecreatetruecolor(400, 300);

// Asignar un color para el polígono
$col_poli = imagecolorallocate($imagen, 255, 255, 255);

// Dibujar el polígono
imagepolygon($imagen, array(
        0,   0,
        100, 200,
        300, 200
    ),
    3,
    $col_poli);

// Imprimir la imagen al navagador
header('Content-type: image/png');

imagepng($imagen);
imagedestroy($imagen);
?>
