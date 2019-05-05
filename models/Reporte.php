<?php 

class Reporte {

    public $fechaInicial;
    public $fechaFinal;

    function Reporte($fechaInicial, $fechaFinal) {
        $this->fechaInicial = $fechaInicial;
        $this->fechaFinal = $fechaFinal;
    }

    function getFechaInicial() {
        return $this->fechaInicial;
    }

    function getFechaFinal() {
        return $this->fechaFinal;
    }

    function setFechaInicial($fechaInicial) {
        $this->fechaInicial = $fechaInicial;
    }
    
    function setFechaFinal($fechaFinal) {
        $this->fechaFinal = $fechaFinal;
    }
}
