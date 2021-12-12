<?php
    require_once "Usuario.php";
    require_once "Tematica.php";
    require_once "Pregunta.php";
    require_once "Respuesta.php";
    require_once "Examen.php";

    class DB{
        private static $conexion;

        public static function abreConexion(){
            self::$conexion = new PDO('mysql:host=localhost;dbname=autoescuela', 'root', '');
        }

        public static function obtieneUsuarios(){
            $array = array();
            $resultado = self::$conexion->query("SELECT id, email, nombre, apellidos, contraseña, fechanac, rol, foto, activo FROM usuario");
            while ($registro = $resultado->fetch()) {
                $u= new Usuario($registro["id"],$registro["email"],$registro["nombre"],$registro["apellidos"],$registro["contraseña"],$registro["fechanac"],$registro["rol"],$registro["foto"],$registro["activo"]);
               $array[]=$u;
            }
            return $array;
        }

        public static function altaUsuario(Usuario $a){
            $contrasenia= md5($a->contrasenia);
            $nombre=$a->nombre;
            $email=$a->email;
            $apellidos=$a->apellidos;
            $rol= $a->rol;
            $fechanac= $a->fechanac;
            $activo= $a->activo;
            
            $consulta = self::$conexion->prepare("Insert into usuario (email, nombre, apellidos, contrasenia, fechanac, rol, activo) VALUES (:email, :nombre, :apellidos, '$contrasenia', :fechanac, :rol, $activo)");

            $consulta->bindParam(':nombre',$nombre);
            $consulta->bindParam(':email',$email);
            $consulta->bindParam(':rol',$rol);
            $consulta->bindParam(':apellidos',$apellidos);
            $consulta->bindParam(':fechanac',$fechanac);
            
            
            return $consulta->execute();
        }

        public static function altaUsuarioMasiva($nombre,$email){
            
            
            $consulta = self::$conexion->prepare("Insert into usuario (email, nombre) VALUES ('$email', '$nombre')");

            $consulta->bindParam(':nombre',$nombre);
            $consulta->bindParam(':email',$email);    
            return $consulta->execute();
        }

        public static function existeUsuario($email,$contrasenia)
        {
           $usuario=null;
           $usuario=self::leeUsuario($email,$contrasenia);
           if($usuario!=null)
           {
               return true;
           }
           else{
               return false;
           }
            
        }

        public static function leeUsuario($email,$contrasenia)
        {
            $u=null;
            $resultado = self::$conexion->query("SELECT id, email, nombre, apellidos, contrasenia, fechanac, rol, foto, activo FROM usuario WHERE email='$email' && contrasenia='$contrasenia'");
            while ($registro = $resultado->fetch()) {
                $u= new Usuario($registro["id"],$registro["email"],$registro["nombre"],$registro["apellidos"],$registro["contrasenia"],$registro["fechanac"],$registro["rol"],$registro["foto"],$registro["activo"]);
            }
            
            return $u;
        }

        public static function leeUsuarioPorId($id)
        {
            $u=null;
            $resultado = self::$conexion->query("SELECT id, email, nombre, apellidos, contrasenia, fechanac, rol, foto, activo FROM usuario WHERE id='$id'");
            while ($registro = $resultado->fetch()) {
                $u= new Usuario($registro["id"],$registro["email"],$registro["nombre"],$registro["apellidos"],$registro["contrasenia"],$registro["fechanac"],$registro["rol"],$registro["foto"],$registro["activo"]);
            }
            
            return $u;
        }

        public static function actualizarCampo(Usuario $a)
        {
            $consulta = self::$conexion->prepare("update users set foto='img/$a->correo.jpg' where correo='$a->correo'");
            return $consulta->execute();
        }

        public static function leeTematicas(){
            $t=null;
            $array = array();
            $resultado = self::$conexion->query("SELECT idtematica, descripcion FROM tematica");
            while ($registro = $resultado->fetch()) {
                $t= new Tematica($registro["idtematica"],$registro["descripcion"]);
                $array[]=$t;
            }
            
            return $array;
        }


        public static function buscaTematicaNombre($descripcion){
            $resultado = self::$conexion->query("SELECT idtematica FROM tematica where descripcion='$descripcion'");
            while ($registro = $resultado->fetch()) {
                $id= $registro["idtematica"];
            }
            
            return $id;
        }


        public static function altaPregunta(Pregunta $p){
            $enunciado= $p->enunciado;
            $tematica=$p->tematica;
            $tematica=intval($tematica);
            $foto=$p->foto;
            
            if($foto!="../img/")
            {
                $consulta = self::$conexion->prepare("Insert into pregunta (enunciado, tematica, foto) VALUES (:enunciado, $tematica, :foto)");

                $consulta->bindParam(':enunciado',$enunciado);
                $consulta->bindParam(':foto',$foto);
             
                return $consulta->execute();
            }
            else{
                $consulta = self::$conexion->prepare("Insert into pregunta (enunciado, tematica) VALUES (:enunciado, $tematica)");

                $consulta->bindParam(':enunciado',$enunciado);
             
                return $consulta->execute();
            }
        }


        public static function altaTematica(Tematica $t){
            $descripcion= $t->descripcion;
            
            $consulta = self::$conexion->prepare("Insert into tematica (descripcion) VALUES (:descripcion)");

            $consulta->bindParam(':descripcion',$descripcion);

            return $consulta->execute();
        }

        public static function altaRespuestas(Respuesta $r){
            $pregunta= $r->pregunta;
            $pregunta=intval($pregunta);
            $enunciado= $r->enunciado;
            
            $consulta = self::$conexion->prepare("Insert into respuesta (pregunta,enunciado) VALUES ($pregunta, :enunciado)");

            $consulta->bindParam(':enunciado',$enunciado);
            
            
            
            return $consulta->execute();

        }

        public static function leeIdPreguntas()
        {
            $resultado = self::$conexion->query("SELECT idpreguntas FROM pregunta order by idpreguntas desc limit 1");
            while ($registro = $resultado->fetch()) {
                $id = $registro['idpreguntas'];
            }
            
            return $id;
        }

        public static function leePreguntas()
        {
            $array = array();
            $resultado = self::$conexion->query("SELECT idpreguntas, enunciado, tematica, foto FROM pregunta");
            while ($registro = $resultado->fetch()) {
                $p = new Pregunta($registro['idpreguntas'],$registro['enunciado'],$registro['tematica'],$registro['foto'],null);
                $array[]=$p;
            }
            
            return $array;
        }

        public static function leePreguntaporID($id)
        {
            $resultado = self::$conexion->query("SELECT idpreguntas, enunciado, tematica, foto, respuesta_correcta FROM pregunta where idpreguntas=$id");
            while ($registro = $resultado->fetch()) {
                $p = new Pregunta($registro['idpreguntas'],$registro['enunciado'],$registro['tematica'],$registro['foto'],$registro['respuesta_correcta']);
            }
            
            return $p;
        }

        public static function leeRespuestaPorPregunta($id)
        {
            $array = array();
            $resultado = self::$conexion->query("select * from respuesta where pregunta = $id");
            while ($registro = $resultado->fetch()) {
                $r = new Respuesta($registro['id'],$registro['pregunta'],$registro['enunciado']);
                $array[]= $r;
            }
            
            return $array;
        }

        public static function leeIdRespuesta($limit)
        {
            $resultado = self::$conexion->query("SELECT id FROM respuesta order by id desc limit $limit");
            while ($registro = $resultado->fetch()) {
                $id = $registro['id'];
            }
            
            return $id;
        }

        public static function actualizaIdPregunta($idpregunta,$idrespuesta){
            
            $consulta = self::$conexion->prepare("Update pregunta set respuesta_correcta='$idrespuesta' where idpreguntas='$idpregunta'");

            return $consulta->execute();

        }


        public static function altaExamen(Examen $e){
            $descripcion= $e->descripcion;
            $duracion=intval($e->duracion);
            $npreguntas=intval($e->npreguntas);
            
            $consulta = self::$conexion->prepare("Insert into examen (descripcion,duracion,npreguntas) VALUES (:descripcion, $duracion, $npreguntas)");

            $consulta->bindParam(':descripcion',$descripcion);
            
            return $consulta->execute();

        }

        public static function leeIdExamen()
        {
            $resultado = self::$conexion->query("SELECT id FROM examen order by id desc limit 1");
            while ($registro = $resultado->fetch()) {
                $id = $registro['id'];
            }
            
            return $id;
        }


        public static function insertaPreguntaExamen($idexamen,$idpregunta){
            
            $consulta = self::$conexion->prepare("Insert into examen_preguntas (idexamen,idpregunta) VALUES ($idexamen,$idpregunta)");
          
            return $consulta->execute();

        }

        public static function actualizaUsuario(Usuario $a){
            $id = intval($a->id);
            $contrasenia= $a->contrasenia;
            $nombre=$a->nombre;
            $email=$a->email;
            $apellidos=$a->apellidos;
            $rol= $a->rol;
            $fechanac= $a->fechanac;
            $activo= $a->activo;
            
            $consulta = self::$conexion->prepare("UPDATE usuario SET email='$email', nombre='$nombre', apellidos='$apellidos', contrasenia='$contrasenia', fechanac='$fechanac' WHERE id=$id");
            return $consulta->execute();
        }

        public static function actualizaUsuarioTabla($id,$nombre,$rol,$fechanac,$activo){
  
            $consulta = self::$conexion->prepare("UPDATE usuario SET nombre='$nombre', rol='$rol', activo='$activo', fechanac='$fechanac' WHERE id=$id");
            return $consulta->execute();
        }

        public static function actualizaTematica($descripcion, $id){
  
            $consulta = self::$conexion->prepare("UPDATE tematica SET descripcion='$descripcion' WHERE idtematica=$id");
            return $consulta->execute();
        }

        public static function actualizaPregunta($enunciado,$id){
        
            $consulta = self::$conexion->prepare("UPDATE pregunta SET enunciado='$enunciado' WHERE idpreguntas=$id");
            return $consulta->execute();
        }

        public static function altaUsuarioConfirm($idusuario, $codigo){
            $id= intval($idusuario);

            $consulta = self::$conexion->prepare("Insert into confirmarusuario (codigoconfirm,idusuario) VALUES ('$codigo', '$id')");

            return $consulta->execute();

        }

        public static function leeIdUsuario()
        {
            $resultado = self::$conexion->query("SELECT id FROM usuario order by id desc limit 1");
            while ($registro = $resultado->fetch()) {
                $id = $registro['id'];
            }
            
            return $id;
        }

        public static function leeIDUsuarioConfirm($codigo)
        {
            $resultado = self::$conexion->query("SELECT idusuario FROM confirmarusuario where codigoconfirm='$codigo'");
            while ($registro = $resultado->fetch()) {
                $id = $registro['idusuario'];
            }
            
            return $id;
        }


        public static function actualizaContraseniaUsuario($id, $contrasenia){
            $idusuario = intval($id);
            
            $consulta = self::$conexion->prepare("UPDATE usuario SET contrasenia='$contrasenia' WHERE id=$id");
            return $consulta->execute();
        }

        public static function borraUsuarioConfirm($codigo){
            
            $consulta = self::$conexion->prepare("delete from confirmarusuario WHERE codigoconfirm='$codigo'");
            return $consulta->execute();
        }

        public static function borraUsuario($codigo){
            
            $consulta = self::$conexion->prepare("delete from usuario WHERE id='$codigo'");
            return $consulta->execute();
        }

        public static function borraTematica($codigo){
            
            $consulta = self::$conexion->prepare("delete from tematica WHERE idtematica='$codigo'");
            return $consulta->execute();
        }

        public static function borraPregunta($codigo){
            
            $consulta = self::$conexion->prepare("delete from pregunta WHERE idpreguntas='$codigo'");
            return $consulta->execute();
        }


        public static function obtieneUsuariosPaginados(int $pagina, int $filas=6):array
        {
            $registros = array();
            $res = self::$conexion->query("select * from usuario");
            $registros =$res->fetchAll();
            $total = count($registros);
            $paginas = ceil($total /$filas);
            $registros = array();
            if ($pagina <= $paginas)
            {
                $inicio = ($pagina-1) * $filas;
                $res= self::$conexion->query("select * from usuario limit $inicio, $filas");
                $registros = $res->fetchAll(PDO::FETCH_ASSOC);
            }
            return $registros;
        }

        public static function obtieneTematicasPaginados(int $pagina, int $filas=6):array
        {
            $registros = array();
            $res = self::$conexion->query("select * from tematica");
            $registros =$res->fetchAll();
            $total = count($registros);
            $paginas = ceil($total /$filas);
            $registros = array();
            if ($pagina <= $paginas)
            {
                $inicio = ($pagina-1) * $filas;
                $res= self::$conexion->query("select * from tematica limit $inicio, $filas");
                $registros = $res->fetchAll(PDO::FETCH_ASSOC);
            }
            return $registros;
        }

        public static function obtieneExamenesPaginados(int $pagina, int $filas=6):array
        {
            $registros = array();
            $res = self::$conexion->query("select * from examen");
            $registros =$res->fetchAll();
            $total = count($registros);
            $paginas = ceil($total /$filas);
            $registros = array();
            if ($pagina <= $paginas)
            {
                $inicio = ($pagina-1) * $filas;
                $res= self::$conexion->query("select * from examen limit $inicio, $filas");
                $registros = $res->fetchAll(PDO::FETCH_ASSOC);
            }
            return $registros;
        }

        public static function obtienePreguntasPaginados(int $pagina, int $filas=6):array
        {
            $registros = array();
            $res = self::$conexion->query("select * from pregunta");
            $registros =$res->fetchAll();
            $total = count($registros);
            $paginas = ceil($total /$filas);
            $registros = array();
            if ($pagina <= $paginas)
            {
                $inicio = ($pagina-1) * $filas;
                $res= self::$conexion->query("select * from pregunta limit $inicio, $filas");
                $registros = $res->fetchAll(PDO::FETCH_ASSOC);
            }
            return $registros;
        }


        public static function leeExamenAleatorio()
        {
            $resultado = self::$conexion->query("select * from examen order by rand() limit 1");
            while ($registro = $resultado->fetch()) {
                $e = new Examen($registro['id'],$registro['descripcion'],$registro['duracion'],$registro['npreguntas'],$registro['activo']);
            } 
            return $e;
        }


        public static function leePreguntasPorExamen($id)
        {
            $array = array();
            $resultado = self::$conexion->query("select idpregunta from examen_preguntas where idexamen = $id");
            while ($registro = $resultado->fetch()) {
                $id = $registro['idpregunta'];
                $array[]=$id;
            } 
            return $array;
        }

    }