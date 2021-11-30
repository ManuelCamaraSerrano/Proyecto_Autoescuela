<?php
class Pregunta  implements JsonSerializable{
    private $id;
    private $enunciado;
    private $tematica;
    private $foto;
    private $respuestaCorrecta;
    private $nombreTematica;
    

    public function __construct($_id, $_enunciado, $_tematica, $_foto, $_respuestaCorrecta){
        $this->id = $_id;
        $this->enunciado = $_enunciado;
        $this->tematica = $_tematica;
        $this->foto = $_foto;
        $this->respuestaCorrecta = $_respuestaCorrecta;

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
        return "ID: ".$this->id." Enunciado: ".$this->enunciado." Tematica: ".$this->tematica;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}