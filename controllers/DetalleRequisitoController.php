<?php
if(!class_exists('Conexion')) {
    include('Conexion.php');
}
if(!class_exists('Area')) {
    include('../models/Area.php');
}
class DetalleRequisitoController {
    
    public $detalle;

    public function DetalleRequisitoController($detalle = null) {
        $this->detalle = $detalle;
    }

    public function crear() {
        
        $fecha = $this->detalle->getFecha();
        $observacion = $this->detalle->getObservacion();
        $fkemple = $this->detalle->getFkemple();
        $fkreq = $this->detalle->getFkreq();
        $fkestado = $this->detalle->getFkestado();
        $fkempleasig = $this->detalle->getFkempleasig();

       
        if(!empty($fkempleasig)) {
            $query = "INSERT INTO DETALLEREQ (FECHA, OBSERVACION, FKEMPLE, FKREQ, FKESTADO, FKEMPLEASIG) 
            VALUES ('".$fecha."', '".$observacion."', ".$fkemple.", ".$fkreq.", ".$fkestado.", ".$fkempleasig.")";
        }else {
            $query = "INSERT INTO DETALLEREQ (FECHA, OBSERVACION, FKEMPLE, FKREQ, FKESTADO) 
            VALUES ('".$fecha."', '".$observacion."', ".$fkemple.", ".$fkreq.", ".$fkestado.")";
        }
        
        $conn = new Conexion();
        $db = $conn->connect();

        try {
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            $sth->closeCursor();
            return $resultado;
        } catch (PDOException $e) {
            header("Location:../views/requisito/crear.php?error=Ocurrio un error update. Error: ".$e->getMessage());
        }
    }

    public function getAreas() {
        
        $query = "SELECT `IDAREA`, `NOMBRE`, `FKEMPLE` FROM `AREA`";
        
        $conn = new Conexion();
        $db = $conn->connect();

        try {
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            if($resultado) {
                $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
            }
            $sth->closeCursor();
            return $resultado;
        } catch (PDOException $e) {
            echo "<pre>";
            var_dump($e->getMessage());
            echo "</pre>";
            die;
        }
    }

    public function lista() {
        $query = "SELECT 
            `AREA`.*,
            `EMPLEADO`.`NOMBRE` AS `LIDER`
        FROM `AREA`
        LEFT JOIN `EMPLEADO` ON `EMPLEADO`.`IDEMPLEADO` = `AREA`.`FKEMPLE`
        ORDER BY `AREA`.`IDAREA`";
        
        $conn = new Conexion();
        $db = $conn->connect();

        try {
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            if($resultado) {
                $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
            }
            $sth->closeCursor();
            return $resultado;
        } catch (PDOException $e) {
            echo "<pre>";
            var_dump($e->getMessage());
            echo "</pre>";
            die;
        }
    }

    public function ver($id) {
        $query = "SELECT 
            `AREA`.`IDAREA`,
            `AREA`.`NOMBRE`,
            `AREA`.`FKEMPLE` AS IDLIDER,
            `EMPLEADO`.`NOMBRE` AS `LIDER`
        FROM `AREA`
        LEFT JOIN `EMPLEADO` ON `EMPLEADO`.`IDEMPLEADO` = `AREA`.`FKEMPLE`
        WHERE `AREA`.`IDAREA` = ".$id."
        ORDER BY `AREA`.`IDAREA`";
        
        $conn = new Conexion();
        $db = $conn->connect();

        try {
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            if($resultado) {
                $resultado = $sth->fetch(PDO::FETCH_ASSOC);
            }
            $sth->closeCursor();
            return $resultado;
        } catch (PDOException $e) {
            echo "<pre>";
            var_dump($e->getMessage());
            echo "</pre>";
            die;
        }
    }

    public function editar($id) {
        
        $nombre = $this->area->getNombre();
        $fkemple = $this->area->getIdDirector();

        if(!empty($fkemple)) {
            $query = "UPDATE `AREA` SET 
            `NOMBRE`='".$nombre."',  `FKEMPLE` = ".$fkemple."
            WHERE `IDAREA` = ".$id;
        }else {
            $query = "UPDATE `AREA` SET 
            `NOMBRE`='".$nombre."'
            WHERE `IDAREA` = ".$id;
        }
                
        
        $conn = new Conexion();
        $db = $conn->connect();

        try {
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            if($resultado) {
                $sth->closeCursor();
                header("Location:../../views/area/lista.php?message=Se actualizo correctamente el área ".$nombre);
            }else {
                $error = $sth->errorInfo();
                $sth->closeCursor();
                header("Location:../../views/area/editar.php?error=Ocurrio un error editando. Error: ".$error[2]);
            }

        } catch (PDOException $e) {
            header("Location:../../views/area/editar.php?error=".$e->getMessage());
        }
        
        
    }
}

