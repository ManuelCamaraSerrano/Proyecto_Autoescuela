<?php
    require_once("../php/Sesion.php");
    Sesion::iniciar();
    if(!Sesion::existe("usuario"))
    {
        header("Location: loginForm.php");
    }

    Sesion::eliminar("usuario");
    Sesion::destruir();
    header("Location: loginForm.php");
    