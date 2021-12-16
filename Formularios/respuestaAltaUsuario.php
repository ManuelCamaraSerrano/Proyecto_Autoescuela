<?php
    require_once "../php/Sesion.php";
    require_once "../php/GBD.php";
    require_once "../php/validacion.php";
    require_once "../php/Usuario.php";
    require_once "../librerias/libreria.php";

    // Iniciamos sesion y si no existe usuario logueado lo mandamos al login
    Sesion::iniciar();     
        
    if(!Sesion::existe("usuario"))
    {
        header("Location: ../login/loginForm.php");
    }
    else{
        if(isset($_GET["m"]))
        {
            $formInsertar=false;
        }
        else{
            $formInsertar=true;
        }
    }
    $u=Sesion::leer("usuario");
    
    $validacion = new Validacion();
        $u= Sesion::leer("usuario");
        if($u->rol=="alumno")
        {
            pintaCabeceraAlumno();
        }
        else{
            pintaCabecera();
        }
        if(isset($_POST['aceptar']))
        {
            // Validamos los datos
            $validacion->Email("email");
            $validacion->CadenaRango("email",30);
            $validacion->Requerido("nombre");
            $validacion->CadenaRango("nombre",20);
            $validacion->Requerido("apellidos");
            $validacion->CadenaRango("apellidos",20);
            $validacion->Requerido("fechanac");
            if(count($validacion->errores)==0)
            {
                if($formInsertar)
                {
                    // Si no hay errores insertamos el usuario
                    DB::abreConexion();
                    $usuario = new Usuario(null,$_POST['email'],$_POST['nombre'],$_POST['apellidos'],generaContrasenia(),$_POST['fechanac'],$_POST['rol'],"",0);
                    $respuesta = DB::altaUsuario($usuario);
                    if($respuesta){
                        // Si se inserto el usuario mostramos un mensaje de que se ha introducido
                        echo "OK";
                        // Leemos el id del ultimo usuario introducido 
                        $idUsuario = DB::leeIdUsuario();
                        // Introducimos en la tabla usuarioConfirmar al ultimo usuario que hemos introducido
                        $codigo = generaContrasenia();
                        $insertado = DB::altaUsuarioConfirm($idUsuario,$codigo);
                        if($insertado)
                        {
                            // Por ultimo le enviamos el correo si se ha metido en la tabla si no le notificamos que ha habido un error
                            enviaCorreo($codigo);
                            echo "OK";
                        }
                        else{
                            echo "Error, no se ha podido introducir el usuario en la tabla de confirmacion";
                        }
                    }
                    else{
                        echo "Error, El usuario no se ha podido introducir";
                    }
                }
                else{
                    // En caso de que estemos en modo modificación creamos el usuario y lo actualizamos
                    if($_FILES['foto']['tmp_name']!="")
                    {
                        // Guardamos la foto en la carpeta img
                        move_uploaded_file($_FILES['foto']['tmp_name'],"../img/".$_FILES['foto']['name']);
                        $foto="../img/".$_FILES['foto']['name'];
                        $usuModi = new Usuario($u->id,$_POST['email'],$_POST['nombre'],$_POST['apellidos'],$u->contrasenia,$_POST['fechanac'],$u->rol,$foto,$u->activo);
                    }
                    else{
                        $usuModi = new Usuario($u->id,$_POST['email'],$_POST['nombre'],$_POST['apellidos'],$u->contrasenia,$_POST['fechanac'],$u->rol,$u->foto,$u->activo);
                    }

                    DB::abreConexion();
                    
                    $respuesta = DB::actualizaUsuario($usuModi);
                    if($respuesta){
                        echo "Usuario Actualizado";
                        Sesion::escribir('usuario',$usuModi);
                        header("Location: FormAltaUsuario.php?m");
                    }
                    else{
                        echo "Error, El usuario no se ha podido actualizar";
                    }
                }
            }
           

            
        }
    ?>