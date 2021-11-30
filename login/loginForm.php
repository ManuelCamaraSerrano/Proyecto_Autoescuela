<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <?php
         require_once("Login.php");
         require_once "../php/Sesion.php";
         require_once "../php/GBD.php";
         Sesion::iniciar();
         $error="";
         if(isset($_COOKIE['recuerdame']))
            {
                $cookie=json_decode($_COOKIE['recuerdame']);
                $email =$cookie[0];
                $contrasenia= $cookie[1];
                $check= true;
            }
    ?>
</head>
<body>
    <?php
        
        if(isset($_POST['login']))
        {
            if(isset($_POST['check']))
            {
                $check=true;
            }
            else{
                $check=false;
            }
            $existe = Login::identificaUsuario($_POST['email'],$_POST['contrasenia'],$check);
            if($existe)
            {
                header("Location: prueba.php");
            }
            else{
                $error="Usuario no encontrado";
            }

        }
    ?>
    <img src="../img/Logo.png" alt="" class="logo"> 
    <form action="loginForm.php" method="post">
        <h1><span>Autoescuela</span> Juanchu</h1>
        <label>Email </label> <input type="text" name="email" class="email" value="<?php echo $email ?>"> <br> <br>
        <label>Contraseña</label>  <input type="text" name="contrasenia" class="contrasenia" value="<?php echo $contrasenia ?>">  <br> <br>
        <?php echo "<p>$error</p>";?>
        <input type="submit" name="login" class="login" value="Iniciar sesión"> <br><br>
        <label class="recuerdame">Recuerdame: </label> <input type="checkbox" name="check" checked=<?php $check ?>> 
        <a href="">¿Has olvidado la contraseña?</a>
    </form>
</body>
</html>