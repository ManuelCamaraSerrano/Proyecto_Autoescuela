<?php
    require_once "Usuario.php";
    require_once "Tematica.php";
    require_once "Pregunta.php";

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
            $contrasenia= $a->contrasenia;
            $nombre=$a->nombre;
            $email=$a->email;
            $apellidos=$a->apellidos;
            $rol= $a->rol;
            $fechanac= $a->fechanac;
            $activo= $a->activo;
            
            $consulta = self::$conexion->prepare("Insert into usuario (email, nombre, apellidos, contrasenia, fechanac, rol, activo) VALUES (:email, :nombre, :apellidos, :contrasenia, :fechanac, :rol, $activo)");

            $consulta->bindParam(':nombre',$nombre);
            $consulta->bindParam(':email',$email);
            $consulta->bindParam(':contrasenia',$contrasenia);
            $consulta->bindParam(':rol',$rol);
            $consulta->bindParam(':apellidos',$apellidos);
            $consulta->bindParam(':fechanac',$fechanac);
            
            
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
    }