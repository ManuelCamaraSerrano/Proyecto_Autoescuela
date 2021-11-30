<?php
    require_once "../php/GBD.php";
    DB::abreConexion();
    $preguntas=DB::leePreguntas();
    $tematicas = DB::leeTematicas();
    // Metemos en el array de preguntas un campo que sea nombre tematica para luego poder mostrar 
    // el nombre en vez del codigo de la tematica
    for($i=0; $i<count($preguntas);$i++){
        $preguntas[$i]->nombreTematica = $tematicas[intval($preguntas[$i]->tematica)-1]->descripcion;
    }
    
    echo json_encode($preguntas);

