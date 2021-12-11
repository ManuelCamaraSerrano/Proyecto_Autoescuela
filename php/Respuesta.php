<?php
class Respuesta implements JsonSerializable{
    private $id;
    private $pregunta;
    private $enunciado;
    
    

    public function __construct($_id, $_pregunta, $_enunciado){
        $this->id = $_id;
        $this->pregunta = $_pregunta;
        $this->enunciado = $_enunciado;
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
        return "ID: ".$this->id." Enunciado: ".$this->enunciado." Pregunta: ".$this->pregunta;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}