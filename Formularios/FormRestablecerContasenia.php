<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <?php
        require_once "../php/Sesion.php";
        require_once "../php/GBD.php";
        require_once "../php/validacion.php";
        require_once "../php/Usuario.php";
        require_once "../librerias/libreria.php";

        $error="";
    ?>
</head>
<body>
    <?php
        if(isset($_POST['aceptar']))
        {
            if($_POST['contraseña']==$_POST['contraseñaConfirm'])
            {
                if(isset($_GET['codigoUsu']))  // Si existe es que estamos creando nuestra contraseña
                {
                    DB::abreConexion();
                    // Leemos el id del usuario
                    $idusuario = DB::leeIDUsuarioConfirm($_GET['codigoUsu']);

                    // Actualizamos la contrasenia
                    $respuesta = DB::actualizaContraseniaUsuario($idusuario,md5($_POST["contraseña"]));

                    if($respuesta)
                    {
                        echo "Usuario actualizado";
                        //Borramos el registro en la tabla usuario por confirmar
                        $borrado = DB::borraUsuarioConfirm($_GET['codigoUsu']);

                        // Registramos al usuario en la aplicación directamente pa que no tenga que pasar por el login
                        $u = DB::leeUsuarioPorId($idusuario);
                        Sesion::iniciar();
                        Sesion::escribir('usuario',$u);
                    }
                    else{
                        echo "No se ha podido actualizar la contraseña";
                    }
                }
                else{
                    // Si no existe estamos en el modo de has olvidado tu contraseña que lo único que hay q hacer es actualizarla
                    // Leemos que usuario es
                    DB::abreConexion();
                    $idusuario = DB::leeUsuarioporGmail($_GET['gmail']);

                     // Actualizamos la contrasenia
                     $respuesta = DB::actualizaContraseniaUsuario($idusuario,md5($_POST["contraseña"]));
                     if($respuesta){
                         echo "Contraseña restablecida";
                     }
                     else{
                         echo "Error, la contraseña no se ha podido restablecer";
                     }
                }

            }
            else{
                $error = "Las contraseñas no son iguales";
            }
        }

    ?>
    <img src="../img/Logo.png" alt="" class="logo" > 
    <form action="" method="post" class="cambiaContrasenia">
        <h1>Introduzca su contraseña</h1>
        <label>Contraseña: </label>   <input type="text" name="contraseña" class="contraseña"> 
        <?php if(isset($validacion->errores['contraseña'])) echo $validacion->errores['contraseña'] ?> <br> <br> 

        <label>Confirmar Contraseña:</label> <input type="text" name="contraseñaConfirm" class="contraseñaConfirm"> 
        <?php if(isset($validacion->errores['contraseñaConfirm'])) echo $validacion->errores['contraseñaConfirm'] ?> <br> <br>
        <?php echo "<p>$error</p>";?>
        <input type="submit" name="aceptar" class="aceptar"  value="Cambiar"> <br> <br>
    </form>
</body>
</html>