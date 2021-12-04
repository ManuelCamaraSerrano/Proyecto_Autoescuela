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
        
        // Iniciamos sesion y si no existe usuario logueado lo mandamos al login
        Sesion::iniciar();     
        
        /*if(!Sesion::existe("usuario"))
        {
            header("Location: ../login/loginForm.php");
        }*/
        
        $validacion = new Validacion();
    ?>
</head>
<body>
    <?php
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
                    DB::altaUsuarioMasiva($cadenadividida[$i][0],$cadenadividida[$i][1]);
                }
            }
        }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <h1>Alta Masiva Usuarios</h1>
        <label>Alumnos: </label> <textarea name="alumnos" rows="10" cols="60"></textarea> 
        <?php if(isset($validacion->errores['alumnos'])) echo $validacion->errores['alumnos'] ?>  
        <input type="file" name="csv" class="csv"  value="csv">
        <input type="submit" name="aceptar" class="aceptar"  value="Aceptar"> 
    </form>
</body>
</html>