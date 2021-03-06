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
            }
            if(isset($_POST['aceptar']))
            {
                $preguntasElegidas = json_decode($_POST["preguntas"]);
                // Validamos los datos
                $validacion->CadenaRango("descripcion",50);
                $validacion->Requerido("descripcion");
                $validacion->Requerido("duracion");
                $validacion->CadenaRango("npreguntas",3);
                $validacion->Requerido("npreguntas");
      
                if(count($validacion->errores)==0 && count($preguntasElegidas)>0)
                {
                    // Introducimos el examen
                    $examen = new Examen (null,$_POST["descripcion"],$_POST["duracion"],$_POST["npreguntas"],null);
                    $respuesta = DB::altaExamen($examen);

                    // Leemos el id del examen introducido anteriormente
                    $idexamen = DB::leeIdExamen();

                    // Insertamos en la tabla pregunta-examen cada idexamen con su idpregunta
                    for($i=0; $i<count($preguntasElegidas); $i++){
                        DB::insertaPreguntaExamen(intval($idexamen),intval($preguntasElegidas[$i]));
                    }
                    
                    if($respuesta)
                    {
                        echo "Examen introducido";
                    }
                    else{
                        echo "Examen no introducido";
                    }
                }
            }
        ?>

    <form action="" method="post" id="form" class="examen">
    <h1>Alta Examen</h1>
        <section>
            <label>Descripcion: </label>  <input type="text" name="descripcion" class="descripcion" id="descripcion"> 
            <?php if(isset($validacion->errores['descripcion']))  echo $validacion->errores['descripcion'] ?>  
        </section>
        <section>
            <label>Duraci??n: </label>  <input type="text" name="duracion" class="duracion" id="duracion" maxlength="3"> 
            <?php if(isset($validacion->errores['duracion'])) echo $validacion->errores['duracion'] ?>  
        </section>
        <section>
            <label>N??mero de Preguntas: </label>  <input type="text" name="npreguntas" class="pequenio" id="npreguntas"> 
            <?php if(isset($validacion->errores['npreguntas']))  echo $validacion->errores['npreguntas'] ?> 
        </section>
            <label>Tem??ticas: </label> <select name="tematica" id="tematica">
                <option value=""></option>
                <?php 
                    // Introducimos todas las tematicas que existen en el combobox
                    $tematicas = DB::leeTematicas();
                    for($i=0; $i<count($tematicas); $i++){
                        echo "<option value=".$tematicas[$i]->id.">".$tematicas[$i]->descripcion."</option>";
                    }
                ?>
            </select>  

        <label>Preguntas insertadas: </label>  <input type="text" name="pinsert" class="pequenio" id="pinsert" readonly="true"> 
        <span class="fa fa-search"></span> <input type="text" id="filtro">

        <main id="preguntas">
        <table editable="" id="tabla" border="1" class="tablaExamen">
            <thead>
                <tr>
                    <th>Enunciado</th>
                    <th>Tematica</th>
                </tr>
            </thead>
            <tbody id="tbody">
            </tbody>
        </table>
        </main>

        <main class="preguntasSeleccionadas">
            <table editable="" id="tabla2" border="1" class="tablaExamen">
                <thead>
                    <tr>
                        <th>Enunciado</th>
                        <th>Tematica</th>
                    </tr>
                </thead>
                <tbody id="tbody2" width="200" height="200">
                </tbody>
            </table>
        </main>
        <input type="submit" name="aceptar" class="aceptar"  value="Aceptar" id="aceptar">
    </form>
    <?php
        pintaPieDePagina();
    ?>
</body>
</html>