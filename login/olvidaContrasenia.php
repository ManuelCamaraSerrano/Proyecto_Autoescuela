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

        $validacion = new Validacion();
    ?>
</head>
<body>
    <?php

        if(isset($_POST['aceptar']))
        {
            // Validamos los datos
            $validacion->Email("gmail");
            $validacion->CadenaRango("gmail",30);

            if(count($validacion->errores)==0)
            {   
                CorreoContraseniaOlvidada($_POST["gmail"]);
                header("Location: loginForm.php");   
            }
            else{
                echo "Error, El gmail no se ha podido enviar";
            }
        }
        
    ?>
<img src="../img/Logo.png" alt="" class="logo" > 
    <form action="" method="post" class="cambiaContrasenia">
        <h1>Introduzca su Gmail</h1>
        <label>Gmail: </label>   <input type="text" name="gmail" class="gmail"> 
        <?php if(isset($validacion->errores['gmail'])) echo $validacion->errores['gmail'] ?> <br> <br> 
        <input type="submit" name="aceptar" class="aceptar"  value="Cambiar"> <br> <br>
    </form>
</body>
</html>