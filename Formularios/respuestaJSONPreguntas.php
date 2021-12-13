<?php
    require_once "../php/GBD.php";
    DB::abreConexion();
    // Leemos las preguntas y las mandamos
    $preguntas=DB::leeListaPreguntas();
    
    echo json_encode($preguntas);

