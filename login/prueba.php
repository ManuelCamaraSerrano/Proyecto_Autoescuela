<?php
    require_once "../php/Sesion.php";
    require_once "../php/Usuario.php";
    Sesion::iniciar();
    if(!Sesion::existe("usuario"))
    {
        header("Location: loginForm.php");
    }
    $u = Sesion::leer('usuario');
    echo "Sesion Iniciada";
    echo "<a href='logoff.php'>Cerrar Sesion</a>";
    echo "<p>ID:".$u->id."</p>";
    echo "<p>Correo:".$u->email."</p>";
    echo "<p>Password:".$u->contrasenia."</p>";