<?php
class Usuario implements JsonSerializable{
    private $id;
    private $email;
    private $nombre;
    private $apellidos;
    private $contrasenia;
    private $fechanac;
    private $rol;
    private $foto;
    private $activo;

    public function __construct($_id, $_email, $_nombre, $_apellidos, $_contrasenia, $_fechanac, $_rol, $_foto, $_activo){
        $this->id = $_id;
        $this->email = $_email;
        $this->nombre = $_nombre;
        $this->apellidos = $_apellidos;
        $this->contrasenia = $_contrasenia;
        $this->fechanac = $_fechanac;
        $this->rol = $_rol;
        $this->foto = $_foto;
        $this->activo = $_activo;
    }

    public function __get($property){
        if(property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value){
        if(property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    public function __toString(){
        return "ID: ".$this->id." Nombre: ".$this->nombre." Apellidos: ".$this->apellidos;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

}