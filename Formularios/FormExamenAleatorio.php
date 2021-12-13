<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../js/Examen.js"></script>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../vendor/fontawesome/css/all.css">
    <script src="../js/realizaExamen.js"></script>
    <?php
        require_once "../php/Sesion.php";
        require_once "../php/GBD.php";
        require_once "../php/validacion.php";
        require_once "../php/Tematica.php";
        require_once "../php/Pregunta.php";
        require_once "../librerias/libreria.php";

        Sesion::iniciar();
        
        if(!Sesion::existe("usuario"))
        {
            header("Location: ../login/loginForm.php");
        }
       DB::abreConexion();
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
        };
    ?>
    <main id="contenedorExamen">

    </main>

    <main class="paginacion" name="paginacion" id="paginacion">

    </main>

    <?php
        pintaPieDePagina();
    ?>
</body>
</html>