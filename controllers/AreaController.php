<?php

class AreaController {
    
    public $area;

    public function AreaController($area) {
        $this->area = $area;
    }

    public function crear() {
        $nombre = $this->area->getNombre();
        $fkemple = $this->area->getIdDirector();

        if(!empty($fkemple)) {
            $query = "INSERT INTO AREA ( NOMBRE, FKEMPLE ) VALUES ('".$nombre."', ".$fkemple.")";
        }else {
            $query = "INSERT INTO AREA ( NOMBRE, FKEMPLE ) VALUES ('".$nombre."')";
        }
        
        $conn = new Conexion();
        $db = $conn->connect();

        try {
            $db->beginTransaction();

            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            $sth->closeCursor();

            $db->commit();
            header("Location:../views/index.php?message=Se creó el área correctamente.");

        } catch (PDOException $e) {
            $db->rollBack();
            header("Location:../index.php?message=".$e->getMessage());
        }
        
        
    }
}
