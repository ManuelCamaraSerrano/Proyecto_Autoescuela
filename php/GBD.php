<?php
    include("Usuario.php");

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
            $nombre=$a->nombre;
            $correo=$a->correo;
            $password=$a->password;
            $roles= $a->roles;
            
            $consulta = self::$conexion->prepare("Insert into users (id, email, nombre, apellidos, contraseña, fechanac, rol, foto, activo) VALUES (null, :email, :nombre, :apellidos, :contraseña, :fechanac, :rol, :foto, :activo)");

            $consulta->bindParam(':Nombre',$nombre);
            $consulta->bindParam(':Correo',$correo);
            $consulta->bindParam(':Password',$password);
            $consulta->bindParam(':Roles',$roles);
            
            $consulta->execute();
        }

        public static function leeUsuario($usuario,$password)
        {
            $u=null;
            $resultado = self::$conexion->query("SELECT nombre, correo, password, roles, foto FROM users where nombre='$usuario' && password='$password'");
            while ($registro = $resultado->fetch()) {
                $u= new Users($registro["nombre"],$registro["correo"],$registro["password"],$registro["roles"]);
                $u->foto= $registro["foto"];
            }

            return $u;
        }

        public static function actualizarCampo(Users $a)
        {
            $consulta = self::$conexion->prepare("update users set foto='img/$a->correo.jpg' where correo='$a->correo'");
            return $consulta->execute();
        }
    }