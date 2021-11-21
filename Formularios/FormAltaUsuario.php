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
        require_once "../php/Usuario.php";
        
        Sesion::iniciar();
        
        if(!Sesion::existe("usuario"))
        {
            header("Location: ../login/loginForm.php");
        }
        $validacion = new Validacion();
    ?>
</head>
<body>
    <?php
    if(isset($_POST['aceptar']))
    {
        // Validamos los datos
        $validacion->Email("email");
        $validacion->CadenaRango("email",30);
        $validacion->Requerido("nombre");
        $validacion->CadenaRango("nombre",20);
        $validacion->Requerido("apellidos");
        $validacion->CadenaRango("apellidos",20);
        $validacion->Requerido("contraseña");
        $validacion->CadenaRango("contraseña",20);
        $validacion->Requerido("contraseñaConfirm");
        $validacion->CadenaRango("contraseña",20);
        $validacion->Requerido("fechanac");

        if(count($validacion->errores)==0)
        {
            // Si no hay errores insertamos el usuario
            $usuario = new Usuario(null,$_POST['email'],$_POST['nombre'],$_POST['apellidos'],$_POST['contraseña'],$_POST['fechanac'],$_POST['rol'],"",0);
            DB::abreConexion();
            $respuesta = DB::altaUsuario($usuario);
            if($respuesta){
                echo "Usuario Introducido";
            }
            else{
                echo "Error, El usuario no se ha podido introducir";
            }
        }

        
    }
    ?>
    <h1>Alta de usuario</h1>
    <form action="" method="post">
        <label>Email: </label>  <input type="text" name="email" class="email"> 
        <?php if(isset($validacion->errores['email'])) echo $validacion->errores['email']?>  <br> <br>

        <label>Nombre: </label>  <input type="text" name="nombre" class="nombre"> 
        <?php if(isset($validacion->errores['nombre'])) echo $validacion->errores['nombre'] ?>  <br> <br>

        <label>Apellidos: </label>  <input type="text" name="apellidos" class="apellidos"> 
        <?php if(isset($validacion->errores['apellidos']))  echo $validacion->errores['apellidos'] ?>  <br> <br> 

        <label>Contraseña: </label>   <input type="text" name="contraseña" class="contraseña"> 
        <?php if(isset($validacion->errores['contraseña'])) echo $validacion->errores['contraseña'] ?> <br> <br> 

        <label>Confirmar Contraseña:</label> <input type="text" name="contraseñaConfirm" class="contraseñaConfirm"> 
        <?php if(isset($validacion->errores['contraseñaConfirm'])) echo $validacion->errores['contraseñaConfirm'] ?> <br> <br>

        <label>Fecha nacimiento: </label> <input type="date" name="fechanac" class="fechanac"> 
        <?php if(isset($validacion->errores['fechanac'])) echo $validacion->errores['fechanac'] ?><br> <br>

        <label>Rol: </label> <select name="rol">
                                <option value="Alumno">Alumno</option>
                                <option value="Administrador">Administrador</option>
                             </select>  <br> <br>
        <input type="submit" name="aceptar" class="aceptar"  value="Aceptar"> <br> <br>
    </form>
</body>
</html>