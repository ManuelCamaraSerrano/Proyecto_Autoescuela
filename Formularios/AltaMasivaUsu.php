<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../vendor/fontawesome/css/all.css">
    <script src="../js/AltaMasivaUsu.js"></script>
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
            $validacion->Requerido("alumnos");

            if(count($validacion->errores)==0)
            {
                // Dividimos la cadena en un array que dentro contiene otro array con el nombre y email de cada usuario
                $cadenadividida=explode("\n",$_POST['alumnos']);
                for($i=0; $i<count($cadenadividida);$i++){
                    $cadenadividida[$i] = explode(";",$cadenadividida[$i]);
                }

                // Luego insertamos cada uno de los usuarios mediante un bucle
                for($i=0; $i<count($cadenadividida);$i++){
                    DB::abreConexion();
                    $respuesta = DB::altaUsuarioMasiva($cadenadividida[$i][0],$cadenadividida[$i][1]);
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
            }
        }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <h1>Alta Masiva Usuarios</h1>
        <label>Alumnos: </label> <textarea name="alumnos" rows="10" cols="60" id="textUsu"></textarea> 
        <?php if(isset($validacion->errores['alumnos'])) echo $validacion->errores['alumnos'] ?>  
        <input type="file" name="csv" class="csv"  value="csv" id="csv" accept=".csv">
        <input type="submit" name="aceptar" class="aceptar"  value="Aceptar"> 
    </form>
    <?php
        pintaPieDePagina();
    ?>
</body>
</html>