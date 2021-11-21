<?php
require_once "../php/Sesion.php";
require_once "../php/GBD.php";
class Login
{
    public static function identificaUsuario(string $email,string $contrasenia,bool $recuerdame)
    {
        //Comprobamos si existe el usuario
        
        if(self::existeUsuario($email,$contrasenia))
        {
            //Iniciamos la sesion y metemos dentro el usuario
            
            $usuario = DB::leeUsuario($email,$contrasenia);
            Sesion::escribir('usuario',$usuario);
            Sesion::escribir('login',$email); 
            //Vemos si quiere que le recordemos la sesión
            if($recuerdame)
            {
                $nombrePass=array();
                $nombrePass[]=$email;
                $nombrePass[]=$contrasenia;
                //Creamos una cookie con el nombre de usuario
                setcookie('recuerdame',json_encode($nombrePass),time()+30*24*60*60);
            }
            return true;
        }
        return false;
    }
    public static function existeUsuario($email, $contrasenia)
    {
        //Comprobamos si existe el usuario
        DB::abreConexion();
        return DB::existeUsuario($email, $contrasenia);
    }
    public static function estaLogueado()
    {
        //Comprobamos si existe la sesion login
        if(isset($_COOKIE['login'])){
            $cookie = json_decode($_COOKIE['login']);
            $cookiEmail= $cookie[0];
            $cookiContrasenia= $cookie[1];
        }
        if(Sesion::leer('login'))
        {
            return true;
        }
        elseif(isset($_COOKIE['recuerdame']) && self::ExisteUsuario($cookiEmail,$cookiContrasenia))
        {
            //Iniciamos la sesion y la creamos(recuerdame)
            Sesion::iniciar();
            Sesion::escribir('login',$_COOKIE['recuerdame']);
            return true;
        }
        return false;
    }
}
