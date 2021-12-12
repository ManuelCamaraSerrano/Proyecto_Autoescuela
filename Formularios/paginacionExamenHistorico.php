<?php
    require_once "../php/GBD.php";
    require_once "../php/Pregunta.php";

    if(!isset($_GET["clase"]))
    {
        DB::abreConexion();
        $array = DB::obtienePreguntasPaginados(1);
        $tematicas = DB::leeTematicas();
        for($i=0;$i<count($array);$i++){
            $p = new Pregunta($array[$i]['idpreguntas'],$array[$i]['enunciado'],$array[$i]['tematica'],$array[$i]['foto'],$array[$i]['respuesta_correcta']);
            $preguntas[]=$p;
        }

        // Metemos en el array de preguntas un campo que sea nombre tematica para luego poder mostrar 
        // el nombre en vez del codigo de la tematica
        for($i=0; $i<count($preguntas);$i++){
            $preguntas[$i]->nombreTematica = $tematicas[intval($preguntas[$i]->tematica)-1]->descripcion;
        }
        
        echo json_encode($preguntas);
    }
    if(isset($_POST['pagina'])){
        DB::abreConexion();
        $array = DB::obtienePreguntasPaginados(intval($_POST["pagina"]));
    
        for($i=0;$i<count($array);$i++){
            $p = new Pregunta($array[$i]['idpreguntas'],$array[$i]['enunciado'],$array[$i]['tematica'],$array[$i]['foto'],$array[$i]['respuesta_correcta']);
            $preguntas[]=$p;
        }
        echo json_encode($preguntas);
        }