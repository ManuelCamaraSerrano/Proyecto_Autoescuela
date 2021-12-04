<?php
spl_autoload_register(function($clase)
{
    //incluir el archivo de la clase
    $fichero=$_SERVER['DOCUMENT_ROOT'].'/Proyecto_Autoescuela/php/'.$clase.'.php';
    if(file_exists($fichero))
    {
        require_once $fichero;
    }
    var_dump($fichero);
});