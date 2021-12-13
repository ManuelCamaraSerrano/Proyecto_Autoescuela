<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../vendor/fontawesome/css/all.css">
    <?php
        require_once "../php/Sesion.php";
        require_once "../php/GBD.php";
        require_once "../php/validacion.php";
        require_once "../php/Tematica.php";
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
    }
    if(isset($_POST['aceptar']))
    {
        // Validamos los datos
        $validacion->CadenaRango("enunciado",150);
        $validacion->Requerido("enunciado");
        $validacion->Requerido("opcion1");
        $validacion->Requerido("opcion2");
        $validacion->Requerido("opcion3");
        $validacion->Requerido("opcion4");
        if(!isset($_POST['opcion'])){
            $validacion->Radiopulsado("opcion");
        }

        if(count($validacion->errores)==0)
        {
            // Si no hay errores insertamos la pregunta
            $pregunta = new Pregunta(null,$_POST['enunciado'],$_POST['tematica'],null,null);

            if(isset($_FILES['foto']))
            {
                // Guardamos la foto en la carpeta img
                move_uploaded_file($_FILES['foto']['tmp_name'],"../img/".$_FILES['foto']['name']);
                $pregunta->foto="../img/".$_FILES['foto']['name'];
            }
            
            $respuesta = DB::altaPregunta($pregunta);

            if($respuesta){
                echo "Pregunta Introducida";
                //Cogemos la id de la ultima pregunta introducida
                $idpregunta = DB::leeIdPreguntas();
                // Introducimos las respuestas
                $r1 = new Respuesta(null,$idpregunta,$_POST['opcion1']);
                DB::altaRespuestas($r1);
                $r2 = new Respuesta(null,$idpregunta,$_POST['opcion2']);
                DB::altaRespuestas($r2);
                $r3 = new Respuesta(null,$idpregunta,$_POST['opcion3']);
                DB::altaRespuestas($r3);
                $r4 = new Respuesta(null,$idpregunta,$_POST['opcion4']);
                DB::altaRespuestas($r4);
                
                    // Introducimos la respuesta correcta en la tabla de preguntas
                    $limit=5;
                    $respuestaCorrecta=$_POST['opcion'];  // Cogemos que radiobutton se ha pulsado
                    $respuestaCorrecta=intval($respuestaCorrecta); // Lo pasamos a entero
                    $idRespuesta=DB::leeIdRespuesta($limit-$respuestaCorrecta); // Leemos el idrespuesta dandole como parametro el $limit- la respuesta que eligio
                    $idRespuesta=intval($idRespuesta);
                    DB::actualizaIdPregunta($idpregunta,$idRespuesta); // Actualizamos el campo
                
            }
            else{
                echo "Error, La pregunta no se ha podido introducir";
            }
        }

        
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data" class="pregunta">
        <h1>Alta de Preguntas</h1>
        <label>Tematica: </label> <select name="tematica">
            <?php 
                // Introducimos todas las tematicas que existen en el combobox
                $tematicas = DB::leeTematicas();
                for($i=0; $i<count($tematicas); $i++){
                    echo "<option value=".$tematicas[$i]->id.">".$tematicas[$i]->descripcion."</option>";
                }
            ?>
        </select>  <br> <br>

        <label>Enunciado: </label> <br> <textarea name="enunciado" rows="8" cols="60"></textarea> 
        <?php if(isset($validacion->errores['enunciado'])) echo $validacion->errores['enunciado'] ?>  <br> <br>

        <label>Foto: </label>  <input type="file" name="foto" class="foto"> 
        <?php if(isset($validacion->errores['apellidos']))  echo $validacion->errores['apellidos'] ?>  <br> <br> 

        <label>Opcion 1:</label> <br>
        <input type="text" name="opcion1" class="opcion1">        
        <input type="radio" name="opcion" class="opcion1" value="1"> 
        <?php if(isset($validacion->errores['opcion1'])) echo $validacion->errores['opcion1'] ?>  <br>

        <label>Opcion 2:</label> <br>
        <input type="text" name="opcion2" class="opcion2"> 
        <input type="radio" name="opcion" class="opcion2" value="2"> 
        <?php if(isset($validacion->errores['opcion2'])) echo $validacion->errores['opcion2'] ?>  <br>

        <label>Opcion 3:</label> <br>
        <input type="text" name="opcion3" class="opcion3"> 
        <input type="radio" name="opcion" class="opcion3" value="3"> 
        <?php if(isset($validacion->errores['opcion3'])) echo $validacion->errores['opcion3'] ?>  <br>

        <label>Opcion 4:</label> <br>
        <input type="text" name="opcion4" class="opcion4"> 
        <input type="radio" name="opcion" class="opcion4" value="4"> 
        <?php if(isset($validacion->errores['opcion4'])) echo $validacion->errores['opcion4'] ?>  <br> <br>
        
        <input type="submit" name="aceptar" class="aceptar"  value="Aceptar"> <br> <br>
    </form>
    <?php if(isset($validacion->errores['opcion'])) echo $validacion->errores['opcion'] ?>
    <?php
        pintaPieDePagina();
    ?>
</body>
</html>