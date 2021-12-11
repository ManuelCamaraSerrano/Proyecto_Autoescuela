<?php
    require_once "../php/GBD.php";
    require_once "../php/Usuario.php";

    if(!isset($_GET["clase"]))
    {
        DB::abreConexion();
        $array = DB::obtieneTematicasPaginados(1);
        for($i=0;$i<count($array);$i++){
            $t = new Tematica($array[$i]['idtematica'],$array[$i]['descripcion']);
            $tematicas[]=$t;
        }
        echo json_encode($tematicas);
    }
    if(isset($_POST['pagina'])){
        DB::abreConexion();
        $array = DB::obtieneTematicasPaginados(intval($_POST["pagina"]));
    
        for($i=0;$i<count($array);$i++){
            $t = new Tematica($array[$i]['idtematica'],$array[$i]['descripcion']);
            $tematicas[]=$t;
        }
        echo json_encode($tematicas);
        }
    

    if(isset($_POST['borrar']))
        {
            DB::abreConexion();
            $respuesta = DB::borraTematica(intval($_POST['borrar']));
            if($respuesta){
                echo "OK";
            }
            else{
                echo "ERROR";
            }
        }

        if(isset($_POST['editar']))
        {
            DB::abreConexion();
            $respuesta = DB::actualizaTematica($_POST['descripcion'],intval($_POST['editar']));
            if($respuesta){
                echo "OK";
            }
            else{
                echo "ERROR";
            }
        }