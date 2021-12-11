<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../vendor/fontawesome/css/all.css">
    <script src="../validacionesJS/validaciones.js"></script>
    <script src="../js/formUsuario.js"></script>
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
    ?>
</head>
<body>
    <?php
        pintaCabecera();
        
    ?>

    <main>
        <table editable="" id="tabla" border="1">
            <thead>
                <tr>
                    <th>Alumno/a</th>
                    <th>Rol</th>
                    <th>Fecha nacimiento</th>
                    <th>Activados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
    </main>
    
    <main class="paginacion" name="paginacion" id="paginacion">

    </main>
    <?php
        pintaPieDePagina();
    ?>
</body>
</html>