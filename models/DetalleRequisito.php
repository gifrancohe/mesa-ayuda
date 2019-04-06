<?php 

class DetalleRequisito {

    public $iddetallereq;
    public $fecha;
    public $observacion;
    public $fkemple;
    public $fkreq;
    public $fkestado;
    public $fkempleasig;

    function DetalleRequisito($fecha, $observacion, $fkemple, $fkreq, $fkestado, $fkempleasig = null ) {
        $this->iddetallereq = $iddetallereq;
        $this->fecha = $fecha;
        $this->observacion = $observacion;
        $this->fkemple = $fkemple;
        $this->fkreq = $fkreq;
        $this->fkestado = $fkestado;
        $this->fkempleasig = $fkempleasig;
    }

    function getIddetallereq() {
        return $this->iddetallereq;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getObservacion() {
        return $this->observacion;
    }

    function getFkemple() {
        return $this->fkemple;
    }

    function getFkreq() {
        return $this->fkreq;
    }

    function getFkestado() {
        return $this->fkestado;
    }

    function getFkempleasig() {
        return $this->fkempleasig;
    }
}
