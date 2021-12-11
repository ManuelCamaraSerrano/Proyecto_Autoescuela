<?php
class Examen implements JsonSerializable{
    private $id;
    private $descripcion;
    private $duracion;
    private $npreguntas;
    private $activo;
    

    public function __construct($_id, $_descripcion, $_duracion, $_npreguntas, $_activo){
        $this->id = $_id;
        $this->descripcion = $_descripcion;
        $this->duracion = $_duracion;
        $this->npreguntas = $_npreguntas;
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
        return "ID: ".$this->id." Descripcion: ".$this->descripcion." Duracion: ".$this->duracion;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}
