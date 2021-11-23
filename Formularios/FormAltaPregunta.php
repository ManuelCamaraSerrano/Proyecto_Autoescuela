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
        $validacion->CadenaRango("enunciado",150);
        $validacion->Requerido("enunciado");

        if(count($validacion->errores)==0)
        {
            // Si no hay errores insertamos la pregunta
            $pregunta = new Pregunta(null,$_POST['enunciado'],$_POST['tematica'],null,null);

            if(isset($_FILES['foto']))
            {
                move_uploaded_file($_FILES['foto']['tmp_name'],"../img/".$_FILES['foto']['name']);
                $pregunta->foto="../img/".$_FILES['foto']['name'];
            }
            
            $respuesta = DB::altaPregunta($pregunta);

            if($respuesta){
                echo "Pregunta Introducida";
            }
            else{
                echo "Error, La pregunta no se ha podido introducir";
            }
        }

        
    }
    ?>
<h1>Alta de Preguntas</h1>
    <form action="" method="post" enctype="multipart/form-data">

        <label>Tematica: </label> <select name="tematica">
            <?php 
                // Introducimos todas las tematicas que existen en el combobox
                $tematicas = DB::leeTematicas();
                for($i=0; $i<count($tematicas); $i++){
                    echo "<option value=".$tematicas[$i]->id.">".$tematicas[$i]->descripcion."</option>";
                }
            ?>
        </select>  <br> <br>

        <label>Enunciado: </label> <br> <textarea name="enunciado" rows="5" cols="20"></textarea> 
        <?php if(isset($validacion->errores['enunciado'])) echo $validacion->errores['enunciado'] ?>  <br> <br>

        <label>Foto: </label>  <input type="file" name="foto" class="foto"> 
        <?php if(isset($validacion->errores['apellidos']))  echo $validacion->errores['apellidos'] ?>  <br> <br> 

        <label>Opcion 1</label> <br>
        <input type="text" name="opcion1" class="opcion1"> 
        <input type="radio" name="opcion" class="opcion1" value="op1"> <br>

        <label>Opcion 2</label> <br>
        <input type="text" name="opcion2" class="opcion2"> 
        <input type="radio" name="opcion" class="opcion2" value="op2"> <br>

        <label>Opcion 3</label> <br>
        <input type="text" name="opcion3" class="opcion3"> 
        <input type="radio" name="opcion" class="opcion3" value="op3"> <br>

        <label>Opcion 4</label> <br>
        <input type="text" name="opcion4" class="opcion4"> 
        <input type="radio" name="opcion" class="opcion4" value="op4"> <br> <br>
        
        <input type="submit" name="aceptar" class="aceptar"  value="Aceptar"> <br> <br>
    </form>
</body>
</html>