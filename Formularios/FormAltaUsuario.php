<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../vendor/fontawesome/css/all.css">+
    <script src="../validacionesJS/validaciones.js"></script>
    <script src="../js//FormuUsuario.js"></script>
    <?php

        require_once "respuestaAltaUsuario.php";
    ?>
</head>
<body>

    <form action="" method="post" enctype="multipart/form-data">
        <h1><?php if(isset($_GET["m"])){ echo "Actualizar Usuario";}else{echo "Alta de usuario";};?></h1>
        <label>Email: </label>  <input type="text" name="email" id="gmail" <?php if(isset($_GET["m"])){ echo "readonly";}else{echo "";};   ?> value=<?php if(!$formInsertar){echo $_SESSION["usuario"]->email;} else{ echo "";}?>> 
        <?php if(isset($validacion->errores['email'])) echo $validacion->errores['email']?>  <br> <br>
        <span id="spanGmail"></span>

        <label>Nombre: </label>  <input type="text" name="nombre" id="nombre" class="nombre" value=<?php if(!$formInsertar){echo $_SESSION["usuario"]->nombre;} else{ echo "";}?>> 
        <?php if(isset($validacion->errores['nombre'])) echo $validacion->errores['nombre'] ?>  <br> <br>
        <span id="spanNombre"></span>

        <label>Apellidos: </label>  <input type="text" name="apellidos" id="apellidos" class="apellidos" value=<?php if(!$formInsertar){echo $_SESSION["usuario"]->apellidos;} else{ echo "";}?>> 
        <?php if(isset($validacion->errores['apellidos']))  echo $validacion->errores['apellidos'] ?>  <br> <br> 
        <span id="spanApellidos"></span>

        <label>Fecha nacimiento: </label> <input type="date" name="fechanac" class="fechanac" id="fechanac" value=<?php if(!$formInsertar){echo $_SESSION["usuario"]->fechanac;} else{ echo "";}?>> 
        <?php if(isset($validacion->errores['fechanac'])) echo $validacion->errores['fechanac'] ?><br> <br>

        <label class=<?php if(isset($_GET["m"])){ echo "modificacion";}else{echo "insertar";};?>>Foto: </label>  
        <input type="file" name="foto" id="foto" class=<?php if(isset($_GET["m"])){ echo "modificacion";}else{echo "insertar";};?>>

        <label>Rol: </label> <select name="rol" id="rol" <?php if(isset($_GET["m"])){ echo "disabled";}else{echo "";};?>>
                                <option value="Alumno">Alumno</option>
                                <option value="Administrador">Administrador</option>
                             </select>  <br> <br>
        <input type="submit" name="aceptar" class="aceptar"  value="Aceptar" id="aceptar"> <br> <br>
    </form>
    <?php
        pintaPieDePagina();
    ?>
</body>
</html>