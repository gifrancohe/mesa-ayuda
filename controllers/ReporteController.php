<?php
if(!class_exists('Conexion')) {
    include('Conexion.php');
}
if(!class_exists('Reporte')) {
    include('../models/Reporte.php');
}
class ReporteController {
    
    public $reporte;

    public function ReporteController($reporte = null) {
        $this->reporte = $reporte;
    }

    public function directorRequisito() {
        
        $fechaInicial = $this->reporte->getFechaInicial();
        $fechaFinal = $this->reporte->getFechaFinal();

        $query = "SELECT `EMPLEADO`.`IDEMPLEADO` 
        FROM `EMPLEADO`
        INNER JOIN `AREA` ON `AREA`.`FKEMPLE` = `EMPLEADO`.`IDEMPLEADO`
        LEFT JOIN `DETALLEREQ` ON `DETALLEREQ`.`FKEMPLE` = `EMPLEADO`.`IDEMPLEADO`
        WHERE `DETALLEREQ`.`FECHA` BETWEEN '".$fechaInicial."' AND '".$fechaFinal."'
        GROUP BY `EMPLEADO`.`IDEMPLEADO`";

        $conn = new Conexion();
        $db = $conn->connect();

        try {
            $directores = array(); //Aquí se guardan los ids de los directores que si redicaron requisitos
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            if($resultado) {
                $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultado as $key => $res) {
                    $directores[] = $res['IDEMPLEADO'];
                }
            }

            $directores = implode(',', $directores);
            
            $query = "SELECT 
                `EMPLEADO`.*,
                `AREA`.`NOMBRE` AS 'AREA'
            FROM `EMPLEADO`
            INNER JOIN `AREA` ON `AREA`.`FKEMPLE` = `EMPLEADO`.`IDEMPLEADO`";

            if(!empty($directores)) {
                $query = $query." WHERE `EMPLEADO`.`IDEMPLEADO` NOT IN (".$directores.")";
            }
            
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            if($resultado) {
                $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            }
        } catch (PDOException $e) {
            header("Location:../views/reporte/requisitos.php?error=Ocurrio un error update. Error: ".$e->getMessage());
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

    public function reporteAreas() {
        $query = "SELECT 
            `AREA`.*,
            `EMPLEADO`.`NOMBRE` AS 'DIRECTOR',
            ( SELECT COUNT(*) FROM `EMPLEADO` WHERE `EMPLEADO`.`FKAREA` = `AREA`.`IDAREA` ) AS 'EMPLEADOS'
        FROM `AREA` 
        LEFT JOIN `EMPLEADO` ON `EMPLEADO`.`IDEMPLEADO` = `AREA`.`FKEMPLE`
        WHERE 1";
        
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

    public function reporteEmpleados() {
        $query = "SELECT 
            `EMPLEADO`.`NOMBRE`,
            `EMPLE1`.NOMBRE AS 'LIDER',
            `AREA`.`NOMBRE` AS 'AREA'
        FROM `EMPLEADO`
        LEFT JOIN `EMPLEADO` AS `EMPLE1` ON `EMPLE1`.IDEMPLEADO = `EMPLEADO`.`FKEMPLE`
        LEFT JOIN `AREA` ON `AREA`.`IDAREA` = `EMPLEADO`.`FKAREA`
        WHERE 1";
        
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

if(!empty($_POST)) {
    if($_GET['create']) {
        
        $reporte = new Reporte(
            $_POST['fechaInicial'], 
            $_POST['fechaFinal']
        );
    
        $reporteCrtl = new ReporteController($reporte);
        $resultado = $reporteCrtl->directorRequisito();
        echo json_encode($resultado, JSON_FORCE_OBJECT);
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
