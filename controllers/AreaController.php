<?php
if(!class_exists('Conexion')) {
    include('Conexion.php');
}
if(!class_exists('Area')) {
    include('../models/Area.php');
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
            $query = "INSERT INTO AREA ( NOMBRE ) VALUES ('".$nombre."')";
        }
        
        $conn = new Conexion();
        $db = $conn->connect();

        try {
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            if($resultado) {
                $sth->closeCursor();
                header("Location:../views/area/crear.php?message=Se creó el área correctamente.");
            }else {
                $error = $sth->errorInfo();
                $sth->closeCursor();
                header("Location:../views/area/crear.php?error=Ocurrio un error update. Error: ".$error[2]);
            }
        } catch (PDOException $e) {
            header("Location:../views/area/crear.php?error=Ocurrio un error update. Error: ".$e->getMessage());
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

if(!empty($_POST['Area'])) {
    if($_GET['create']) {
        
        $area = new Area(
            $_POST['Area']['nombre'], 
            $_POST['Area']['fkemple']
        );
    
        $areaCrtl = new AreaController($area);
        $areaCrtl->crear();
    }
    if($_GET['edit']) {
        $area = new Area(
            $_POST['Area']['nombre'], 
            $_POST['Area']['fkemple']
        );

        $areaCrtl = new AreaController($area);
        $areaCrtl->editar($_POST['Area']['idarea']);
    }
}
