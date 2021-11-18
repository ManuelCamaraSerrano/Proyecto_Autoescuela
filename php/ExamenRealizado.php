<?php
class ExamenRealizado{
    private $idExamenRealizado;
    private $idExamen;
    private $idUsuario;
    private $fecha;
    private $ejecucion;
    

    public function __construct($_idExamenRealizado, $_idExamen, $_idUsuario, $_fecha, $_ejecucion){
        $this->id = $_idExamenRealizado;
        $this->descripcion = $_idExamen;
        $this->duracion = $_idUsuario;
        $this->npreguntas = $_fecha;
        $this->activo = $_ejecucion;
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
        return "ID: ".$this->idExamenRealizado." Examen: ".$this->idExamen." Usuario: ".$this->idUsuario;
    }
}