<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../vendor/fontawesome/css/all.css">
    <script src="../js/AltaMasivaPreguntas.js"></script>
    <?php
        require_once "../php/Sesion.php";
        require_once "../php/GBD.php";
        require_once "../php/validacion.php";
        require_once "../php/Pregunta.php";
        require_once "../librerias/libreria.php";
        
        // Iniciamos sesion y si no existe usuario logueado lo mandamos al login
        Sesion::iniciar();     
        
        /*if(!Sesion::existe("usuario"))
        {
            header("Location: ../login/loginForm.php");
        }*/
        
        $validacion = new Validacion();
    ?>
</head>
<body>
    <?php
        pintaCabecera();
            if(isset($_POST['aceptar']))
            {
                // Validamos los datos
                $validacion->Requerido("preguntas");

                if(count($validacion->errores)==0)
                {
                    // Dividimos la cadena en un array que dentro contiene otro array con el nombre y email de cada usuario
                    $cadenadividida=explode("\n",$_POST['preguntas']);
                    for($i=0; $i<count($cadenadividida);$i++){
                        $cadenadividida[$i] = explode(";",$cadenadividida[$i]);
                    }

                    // Luego insertamos cada uno de los usuarios mediante un bucle
                    for($i=0; $i<count($cadenadividida);$i++){
                        DB::abreConexion();
                        $idtematica = DB::buscaTematicaNombre($cadenadividida[$i][1]);
                        $pregunta = new Pregunta(null,$cadenadividida[$i][0],$idtematica,$cadenadividida[$i][2],null);
                        $respuesta = DB::altaPregunta($pregunta);
                        if($respuesta){
                            // Si se inserto la pregunta mostramos un mensaje de que se ha introducido
                            echo "Pregunta Introducida";
                            // Leemos el id de la ultima pregunta introducida
                            $idpregunta = DB::leeIdPreguntas();
                            // Introducimos las respuestas
                            $r1 = new Respuesta(null,$idpregunta,$cadenadividida[$i][3]);
                            DB::altaRespuestas($r1);
                            $r2 = new Respuesta(null,$idpregunta,$cadenadividida[$i][4]);
                            DB::altaRespuestas($r2);
                            $r3 = new Respuesta(null,$idpregunta,$cadenadividida[$i][5]);
                            DB::altaRespuestas($r3);
                            $r4 = new Respuesta(null,$idpregunta,$cadenadividida[$i][6]);
                            DB::altaRespuestas($r4);
                            
                            // Introducimos la respuesta correcta en la tabla de preguntas
                            $limit=5;
                            $idRespuesta=DB::leeIdRespuesta($limit-intval($cadenadividida[$i][7])); // Leemos el idrespuesta dandole como parametro el $limit- la respuesta que eligio
                            $idRespuesta=intval($idRespuesta);
                            DB::actualizaIdPregunta($idpregunta,$idRespuesta); // Actualizamos el campo 
                          
                        }
                        else{
                            echo "Error, La pregunta no se ha podido introducir";
                        }
                    }
                }
            }
        ?>
    <form action="" method="post" enctype="multipart/form-data">
        <h1>Alta Masiva de Preguntas</h1>
        <label>Preguntas: </label> <textarea name="preguntas" rows="10" cols="60" id="textPreguntas"></textarea> 
        <?php if(isset($validacion->errores['preguntas'])) echo $validacion->errores['preguntas'] ?>  
        <input type="file" name="csv" class="csv"  value="csv" id="csv" accept=".csv">
        <input type="submit" name="aceptar" class="aceptar"  value="Aceptar"> 
    </form>
    <?php
        pintaPieDePagina();
    ?>
</body>
</html>