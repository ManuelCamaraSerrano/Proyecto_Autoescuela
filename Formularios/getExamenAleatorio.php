<?php
    require_once "../php/GBD.php";
    require_once "../php/Examen.php";
    require_once "../php/Sesion.php";

    DB::abreConexion();

    // Leemos un examen aleatorio
    $examen = DB::leeExamenAleatorio();

    // Leemos los id de las preguntas que tiene el examen que hemos elegido
    $arrayIdPreguntas = DB::leePreguntasPorExamen(intval($examen->id));

    // Por cada id de pregunta que hay en el array cogemos de la BD la pregunta entera
    $arrayPreguntas = array();
    for($i=0; $i<count($arrayIdPreguntas); $i++){
        $pregunta = DB::leePreguntaporID(intval($arrayIdPreguntas[$i]));
        $arrayPreguntas[] = $pregunta;
    }

    // Por cada pregunta leemos sus respuestas
    $arrayRespuestas = array();
    for($i=0; $i<count($arrayIdPreguntas); $i++){
        $respuesta = DB::leeRespuestaPorPregunta(intval($arrayIdPreguntas[$i]));
        $arrayRespuestas[] = $respuesta;
    }

    $examenCompleto = array();
    for($i=0; $i<count($arrayIdPreguntas); $i++){
        $examenCompleto[$i] = [$examen,$arrayPreguntas[$i],$arrayRespuestas[$i]];
    }

    echo json_encode($examenCompleto);



    if(isset($_POST["exBarajado"]) && $_POST["respuestas"])
    {
        Sesion::iniciar();
        $u = Sesion::leer("usuario");
        $examenBarajado = json_decode($_POST["exBarajado"]);
        $respuestas = json_decode($_POST["respuestas"]);

        $arrayFinal = array_merge($examenBarajado,$respuestas);

        DB::abreConexion();
        $introducido = DB::altaExamenRealizado($examenBarajado[0][0]->id,$u->id,json_encode($arrayFinal));

        if($introducido){
            echo "ok";
            header("Location: formUsuario.php");
        }
        else{
            echo "no";
        }

    }

    
