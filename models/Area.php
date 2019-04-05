<?php 

class Area {

    public $idarea;
    public $nombre;
    public $fkemple;

    function Area($nombre, $fkemple) {
        $this->nombre = $nombre;
        $this->fkemple = $fkemple;
    }

    function getId() {
        return $this->idarea;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getIdDirector() {
        return $this->fkemple;
    }

    function setId($id) {
        $this->idarea = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    function setIdDirector($idDirector) {
        $this->flemple = $idDirector;
    }
}
