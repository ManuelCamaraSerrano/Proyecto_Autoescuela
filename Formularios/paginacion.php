<?php
    require_once "../php/GBD.php";
    require_once "../php/Usuario.php";

    if(!isset($_GET["clase"]))
    {
        DB::abreConexion();
        $array = DB::obtieneUsuariosPaginados(1);
        for($i=0;$i<count($array);$i++){
            $u = new Usuario($array[$i]['id'],$array[$i]['email'],$array[$i]['nombre'],$array[$i]['apellidos'],$array[$i]['contrasenia'],$array[$i]['fechanac'],$array[$i]['rol'],$array[$i]['foto'],$array[$i]['activo']);
            $usuarios[]=$u;
        }
        echo json_encode($usuarios);
        
    }

  /*  if($_GET["clase"]=="usuario "){
        DB::abreConexion();
        $array = DB::obtieneUsuariosPaginados(intval($_GET["pagina"]));

        for($i=0;$i<count($array);$i++){
            $u = new Usuario($array[$i]['id'],$array[$i]['email'],$array[$i]['nombre'],$array[$i]['apellidos'],$array[$i]['contrasenia'],$array[$i]['fechanac'],$array[$i]['rol'],$array[$i]['foto'],$array[$i]['activo']);
            $usuarios[]=$u;
        }
        echo json_encode($usuarios);
    }*/