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
    if(isset($_POST['pagina'])){
        DB::abreConexion();
        $array = DB::obtieneUsuariosPaginados(intval($_POST["pagina"]));
    
        for($i=0;$i<count($array);$i++){
            $u = new Usuario($array[$i]['id'],$array[$i]['email'],$array[$i]['nombre'],$array[$i]['apellidos'],$array[$i]['contrasenia'],$array[$i]['fechanac'],$array[$i]['rol'],$array[$i]['foto'],$array[$i]['activo']);
            $usuarios[]=$u;
        }
        echo json_encode($usuarios);
        }
    

    if(isset($_POST['borrar']))
        {
            DB::abreConexion();
            $respuesta = DB::borraUsuario(intval($_POST['borrar']));
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
            $respuesta = DB::actualizaUsuarioTabla(intval($_POST['editar']),$_POST['nombre'],$_POST['rol'],$_POST['fechanac'],intval($_POST['activo']));
            if($respuesta){
                echo "OK";
            }
            else{
                echo "ERROR";
            }
        }

    