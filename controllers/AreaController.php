<?php
if(!class_exists('Conexion')) {
    include('Conexion.php');
}
class AreaController {
    
    public $area;

    public function AreaController($area = null) {
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
}
