<?php
class Tematica{
    private $id;
    private $descripcion;
    
    

    public function __construct($_id, $_descripcion){
        $this->id = $_id;
        $this->descripcion = $_descripcion;
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
        return "ID: ".$this->id." Descripcion: ".$this->descripcion;
    }
}