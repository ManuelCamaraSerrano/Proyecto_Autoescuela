<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
         require_once("include/Sesion.php");
         require_once("include/GBD.php");
    ?>
</head>
<body>
    <h1>LOGIN: </h1> 
    <form action="" method="post">
        Usuario: <input type="text" name="usuario" class="usuario"> <br> <br>
        Contraseña: <input type="text" name="password" class="password">  <br> <br>
        <input type="submit" name="iniciar" class="iniciar"> <br> <br>
        Recuerdame: <input type="checkbox" name="check"> 
    </form>
</body>
</html>