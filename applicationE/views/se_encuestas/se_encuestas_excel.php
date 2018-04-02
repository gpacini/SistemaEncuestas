<?php

$filename = $nombre."_respuestas".".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

$lfcr = chr(10);

$records = array( );
$total = 0;
foreach($respuestas as $respuesta){
    $respuesta_n = array( 
        "Cultura" => $respuesta->cultura,
        "Categoria" => $respuesta->categoria,
        "Respuesta" => $respuesta->calificacion,
    );
    array_push($records, $respuesta_n);
    $total ++;
}

$heading = false;
if (!empty($records)){
    foreach ($records as $row) {
        if (!$heading) {
            // display field/column names as a first row
            echo implode("\t", array_keys($row)) . "\r\n";
            $heading = true;
        }
        echo implode("\t", array_values($row)) . "\r\n";
    }
}
exit;