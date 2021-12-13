<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../vendor/fontawesome/css/all.css">
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
    ?>
</head>
<body>
    <?php
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
                        echo "Usuario Introducido";
                        // Leemos el id del ultimo usuario introducido 
                        $idUsuario = DB::leeIdUsuario();
                        // Introducimos en la tabla usuarioConfirmar al ultimo usuario que hemos introducido
                        $codigo = generaContrasenia();
                        $insertado = DB::altaUsuarioConfirm($idUsuario,$codigo);
                        if($insertado)
                        {
                            // Por ultimo le enviamos el correo si se ha metido en la tabla si no le notificamos que ha habido un error
                            enviaCorreo($codigo);
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

    <form action="" method="post" enctype="multipart/form-data">
        <h1><?php if(isset($_GET["m"])){ echo "Actualizar Usuario";}else{echo "Alta de usuario";};?></h1>
        <label>Email: </label>  <input type="text" name="email" <?php if(isset($_GET["m"])){ echo "readonly";}else{echo "";};   ?> value=<?php if(!$formInsertar){echo $_SESSION["usuario"]->email;} else{ echo "";}?>> 
        <?php if(isset($validacion->errores['email'])) echo $validacion->errores['email']?>  <br> <br>

        <label>Nombre: </label>  <input type="text" name="nombre" class="nombre" value=<?php if(!$formInsertar){echo $_SESSION["usuario"]->nombre;} else{ echo "";}?>> 
        <?php if(isset($validacion->errores['nombre'])) echo $validacion->errores['nombre'] ?>  <br> <br>

        <label>Apellidos: </label>  <input type="text" name="apellidos" class="apellidos" value=<?php if(!$formInsertar){echo $_SESSION["usuario"]->apellidos;} else{ echo "";}?>> 
        <?php if(isset($validacion->errores['apellidos']))  echo $validacion->errores['apellidos'] ?>  <br> <br> 

        <label>Fecha nacimiento: </label> <input type="date" name="fechanac" class="fechanac" value=<?php if(!$formInsertar){echo $_SESSION["usuario"]->fechanac;} else{ echo "";}?>> 
        <?php if(isset($validacion->errores['fechanac'])) echo $validacion->errores['fechanac'] ?><br> <br>

        <label class=<?php if(isset($_GET["m"])){ echo "modificacion";}else{echo "insertar";};?>>Foto: </label>  
        <input type="file" name="foto" class=<?php if(isset($_GET["m"])){ echo "modificacion";}else{echo "insertar";};?>>

        <label>Rol: </label> <select name="rol" <?php if(isset($_GET["m"])){ echo "disabled";}else{echo "";};?>>
                                <option value="Alumno">Alumno</option>
                                <option value="Administrador">Administrador</option>
                             </select>  <br> <br>
        <input type="submit" name="aceptar" class="aceptar"  value="Aceptar"> <br> <br>
    </form>
    <?php
        pintaPieDePagina();
    ?>
</body>
</html>