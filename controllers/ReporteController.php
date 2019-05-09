<?php
if(!class_exists('Conexion')) {
    include('Conexion.php');
}
if(!class_exists('Reporte')) {
    include('../models/Reporte.php');
}
class ReporteController {
    
    public $reporte;

    /**
     * Constructor del controlador donde se instancia un objeto de tipo reporte
     */
    public function ReporteController($reporte = null) {
        $this->reporte = $reporte;
    }

    /**
     * Retorna el reporte con el nombre de las áreas, el director de dicha área 
     * y el número de empleados asigandos a cada una de las áreas
     */
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

    /**
     * Retorna el reporte con el nombre de los empleados
     * el nombre del lider de cada uno de los empleados
     * incluyendo el nombre del área a la que pertenece cada empleado
     */
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

    /**
     * Retorna la información de los directores que no han radicado requisitos
     * entre un rango de fechas.
     */
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

    /**
     * Retorna las observaciones de los requisitos que no han sido solucionados totalmente
     * entre un rango de fechas
     */
    public function observacionNoSolucionados() {
        
        $fechaInicial = $this->reporte->getFechaInicial();
        $fechaFinal = $this->reporte->getFechaFinal();

        $query = "SELECT `DETALLEREQ`.`FKREQ`
        FROM `DETALLEREQ`
        INNER JOIN `REQUISITO`ON `REQUISITO`.`IDREQ` = `DETALLEREQ`.`FKREQ` AND `REQUISITO`.`FKESTADO` <> 4
        WHERE `DETALLEREQ`.`FECHA` BETWEEN '".$fechaInicial."' AND '".$fechaFinal."'
        AND `DETALLEREQ`.`FKESTADO` = 1";

        $conn = new Conexion();
        $db = $conn->connect();

        try {
            $requisitos = array(); //Aquí se guardan los ids de los requisitos que no fueron solucionados totalmente en un rango de fechas
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            if($resultado) {
                $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultado as $key => $res) {
                    $requisitos[] = $res['FKREQ'];
                }
            }

            $requisitos = implode(',', $requisitos);
            
            if(!empty($requisitos)) {

                $query = "SELECT 
                    `DETALLEREQ`.`OBSERVACION`,
                    `DETALLEREQ`.`FKREQ`,
                    `DETALLEREQ`.`FECHA`,
                    `ESTADO`.`NOMBRE`,
                    `EMPLEADO`.`NOMBRE` AS 'EMPLEADO'
                FROM `DETALLEREQ`
                LEFT JOIN `ESTADO` ON `ESTADO`.`IDESTADO` = `DETALLEREQ`.`FKESTADO`
                LEFT JOIN `EMPLEADO` ON `EMPLEADO`.`IDEMPLEADO` = `DETALLEREQ`.`FKEMPLE`
                WHERE `DETALLEREQ`.`FKREQ` IN (".$requisitos.")
                ORDER BY `DETALLEREQ`.`FKREQ`, `DETALLEREQ`.`FECHA`";
    
                $sth = $db->prepare($query);
                $resultado = $sth->execute();
                if($resultado) {
                    $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
                    return $resultado;
                }
            }else{
                return null;
            }
            
        } catch (PDOException $e) {
            header("Location:../views/reporte/requisitos.php?error=Ocurrio un error update. Error: ".$e->getMessage());
        }
    }

    /**
     * Retorna los nombres de los empleados asigandos a requisitos que no fueron solucionados totalmente
     * en un rango de fechas determinado
     */
    public function nombresNoSolucionados() {
        
        $fechaInicial = $this->reporte->getFechaInicial();
        $fechaFinal = $this->reporte->getFechaFinal();

        $query = "SELECT `DETALLEREQ`.`FKREQ`
        FROM `DETALLEREQ`
        INNER JOIN `REQUISITO`ON `REQUISITO`.`IDREQ` = `DETALLEREQ`.`FKREQ` AND `REQUISITO`.`FKESTADO` <> 4
        WHERE `DETALLEREQ`.`FECHA` BETWEEN '".$fechaInicial."' AND '".$fechaFinal."'
        AND `DETALLEREQ`.`FKESTADO` = 1";

        $conn = new Conexion();
        $db = $conn->connect();

        try {
            $requisitos = array(); //Aquí se guardan los ids de los requisitos que no fueron solucionados totalmente en un rango de fechas
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            if($resultado) {
                $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
                foreach ($resultado as $key => $res) {
                    $requisitos[] = $res['FKREQ'];
                }
            }

            $requisitos = implode(',', $requisitos);
            
            if(!empty($requisitos)) {

                $query = "SELECT 
                    `DETALLEREQ`.`OBSERVACION`,
                    `DETALLEREQ`.`FKREQ`,
                    `DETALLEREQ`.`FECHA`,
                    `ESTADO`.`NOMBRE`,
                    `EMPLEADO`.`NOMBRE` AS 'EMPLEADO'
                FROM `DETALLEREQ`
                LEFT JOIN `ESTADO` ON `ESTADO`.`IDESTADO` = `DETALLEREQ`.`FKESTADO`
                LEFT JOIN `EMPLEADO` ON `EMPLEADO`.`IDEMPLEADO` = `DETALLEREQ`.`FKEMPLE`
                WHERE `DETALLEREQ`.`FKREQ` IN (".$requisitos.")
                ORDER BY `DETALLEREQ`.`FKREQ`, `DETALLEREQ`.`FECHA`";
    
                $sth = $db->prepare($query);
                $resultado = $sth->execute();
                if($resultado) {
                    $resultado = $sth->fetchAll(PDO::FETCH_ASSOC);
                    return $resultado;
                }
            }else{
                return null;
            }
            
        } catch (PDOException $e) {
            header("Location:../views/reporte/requisitos.php?error=Ocurrio un error update. Error: ".$e->getMessage());
        }
    }
}

/**
 * Código donde se valida el envío POST y cual es el reporte que se quiere obtener
 */
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
    if($_GET['observacion']) {
        
        $reporte = new Reporte(
            $_POST['fechaInicial'], 
            $_POST['fechaFinal']
        );
    
        $reporteCrtl = new ReporteController($reporte);
        $resultado = $reporteCrtl->observacionNoSolucionados();
        echo json_encode($resultado, JSON_FORCE_OBJECT);
    }
    if($_GET['nombres']) {
        
        $reporte = new Reporte(
            $_POST['fechaInicial'], 
            $_POST['fechaFinal']
        );
    
        $reporteCrtl = new ReporteController($reporte);
        $resultado = $reporteCrtl->nombresNoSolucionados();
        echo json_encode($resultado, JSON_FORCE_OBJECT);
    }
}
