<?php
    require_once "../php/GBD.php";
    require_once "../php/Examen.php";

    if(!isset($_GET["clase"]))
    {
        DB::abreConexion();
        $array = DB::obtieneExamenesPaginados(1);
        for($i=0;$i<count($array);$i++){
            $e = new Examen($array[$i]['id'],$array[$i]['descripcion'],$array[$i]['duracion'],$array[$i]['npreguntas'],$array[$i]['activo']);
            $examenes[]=$e;
        }
        
        echo json_encode($examenes);
    }
    if(isset($_POST['pagina'])){
        DB::abreConexion();
        $array = DB::obtieneExamenesPaginados(intval($_POST["pagina"]));
    
        for($i=0;$i<count($array);$i++){
            $e = new Examen($array[$i]['id'],$array[$i]['descripcion'],$array[$i]['duracion'],$array[$i]['npreguntas'],$array[$i]['activo']);
            $examenes[]=$e;
        }
        echo json_encode($examenes);
    }