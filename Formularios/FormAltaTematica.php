<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        require_once "../php/Sesion.php";
        require_once "../php/GBD.php";
        require_once "../php/validacion.php";
        require_once "../php/Tematica.php";

        Sesion::iniciar();
        
        /*if(!Sesion::existe("usuario"))
        {
            header("Location: ../login/loginForm.php");
        }*/

        DB::abreConexion();
        $validacion = new Validacion();
    ?>
</head>
<body>

    <?php
        if(isset($_POST['aceptar']))
        {
            // Validamos los datos
            $validacion->CadenaRango("descripcion",20);
            $validacion->Requerido("descripcion");

            if(count($validacion->errores)==0)
            {
                // Si no hay errores insertamos la pregunta
                $tematica = new Tematica(null,$_POST['descripcion'],);
                
                $respuesta = DB::altaTematica($tematica);

                if($respuesta){
                    echo "Tematica Introducida";
                }
                else{
                    echo "Error, La tematica no se ha podido introducir";
                }
            }

            
        }
        ?>

    <h1>Alta Tematicas</h1>
    <form action="" method="post" >

        <label>Descripcion: </label>  <input type="text" name="descripcion" class="descripcion"> 
        <?php if(isset($validacion->errores['descripcion']))  echo $validacion->errores['descripcion'] ?>  <br> <br> 

        <input type="submit" name="aceptar" class="aceptar"  value="Aceptar"> <br> <br>
    </form>
    
</body>
</html>