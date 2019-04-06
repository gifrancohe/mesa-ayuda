<?php 

class Requisito {

    public $idreq;
    public $fkarea;
    public $fkestado;

    function Requisito($fkarea, $fkestado) {
        $this->fkarea = $fkarea;
        $this->fkestado = $fkestado;
    }

    function getId() {
        return $this->idarea;
    }

    function getFkarea() {
        return $this->fkarea;
    }

    function getFkestado() {
        return $this->fkestado;
    }

    function setIdreq($id) {
        $this->idreq = $id;
    }

    function setFkarea($fkarea) {
        $this->fkarea = $fkarea;
    }
    
    function setFkemple($fkestado) {
        $this->fkestado = $fkestado;
    }
}
