<?php
    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    include('../bd/database.php');
    session_start();

    class Radicar {
        
        public $db;
        
        function __construct($objetoPDO) {
            $this->db = $objetoPDO;
        }

        /**
         * Función que permite radicar un requisito
         */
        public function radicar($data) {
            if(!empty($data)) {
                
                try {
                    $this->db->beginTransaction();
                    
                    // Insertamos el requisito
                    $query = "INSERT INTO REQUISITO (FKAREA) VALUES (:area)";
                    $sth = $this->db->prepare($query);
                    $resultado = $sth->execute(array(":area" => $data['radicado-area']));
                    $id = $this->db->lastInsertId();
                    $sth->closeCursor();

                    if ($resultado && $id) {
                        // Insertamos el detalle del requisito
                        $fecha = date('Y-m-d h:i:s');
                        $estado = 1;
                        $query = "INSERT INTO DETALLEREQ (FECHA, OBSERVACION, FKEMPLE, FKREQ, FKESTADO, FKEMPLEASIG) 
                        VALUES ('".$fecha."', '".$data['radicado-text']."', ".$_SESSION['IDEMPLEADO'].", ".$id.", ".$estado.", ".$data['radicado-empleado'].")";
                        $sth = $this->db->prepare($query);
                        $resultado = $sth->execute();
                        $sth->closeCursor();
                        
                        // commit the transaction
                        if($this->db->commit()) {
                            header("Location:../index.php?message=Requisito creado correctamente.");
                        }else {
                            header("Location:../index.php?message=Ocurrio un error al crear el requisito, intentelo nuevamente.");
                        }
            
                        return true;
                    }else {
                        header("Location:../index.php?message=No se creo el requisito.");
                    }
        
                        
                    
                } catch (PDOException $e) {
                    $this->db->rollBack();
                    header("Location:../index.php?message=".$e->getMessage());
                }
            }   
        }

        /**
         * Función que retorna las áreas que se han creado en el sistema
         * @param Array $areas
         */
        public function obtenerAreas() {
            
            $query = "SELECT * FROM AREA";
            $sth = $this->db->prepare($query);
            $resultado = $sth->execute();

            if($resultado !== false){
                $areas = $sth->fetchAll(PDO::FETCH_ASSOC);
            }

            if(empty($areas)) {
                $areas = [
                    1 => 'Sistemas',
                    2 => 'Gestión Humana',
                    3 => 'Mantenimiento'
                ];
            }
            return $areas;
        }

        /**
         * Función que retorna los requisitos pertenecientes al área de la persona
         * que tiene iniciada la sessión
         * @param Array $requisitos
         */
        public function getRequisitos() {
            $idArea = $_SESSION['FKAREA'];

            $query = "SELECT * FROM `REQUISITO` AS `REQ`
            INNER JOIN `DETALLEREQ` AS `DET` ON `DET`.FKREQ = `REQ`.IDREQ
            INNER JOIN `AREA` ON `AREA`.`IDAREA` = `REQ`.FKAREA
            WHERE `REQ`.FKAREA = ".$idArea." 
            AND `DET`.FKESTADO = 1";
            
            $sth = $this->db->prepare($query);
            $resultado = $sth->execute();
            $requisitos = [];
            if($resultado !== false){
                $requisitos = $sth->fetchAll(PDO::FETCH_ASSOC);
            }

            return $requisitos;
        }

        /**
         * Función que retorna los empleados
         * @param Array $empleados
         */
        public function obtenerEmpleados() {
            $query = "SELECT * FROM EMPLEADO";
            $sth = $this->db->prepare($query);
            $resultado = $sth->execute();

            $empleados = [];
            if($resultado !== false){
                $empleados = $sth->fetchAll(PDO::FETCH_ASSOC);
            }
            return $empleados;
        }

        /**
         * Función que permite asignar los requisitos a un empleado especifico
         */
        public function asignarRequisitos($data) {
            if(!empty($data)) {
                try {
                    $this->db->beginTransaction();
                    
                    foreach( $data['requisitos'] as $key => $req) {
                        // Insertamos el detalle del requisito
                        $fecha = date('Y-m-d h:i:s');
                        $estado = 2; //Estado Asignado
                        $query = "INSERT INTO DETALLEREQ (FECHA, OBSERVACION, FKEMPLE, FKREQ, FKESTADO) 
                        VALUES ('".$fecha."', '".$data['radicado-text']."', ".$_SESSION['IDEMPLEADO'].", ".$key.", ".$estado.")";
                        $sth = $this->db->prepare($query);
                        $resultado = $sth->execute();
                        $sth->closeCursor();
                        
                        // commit the transaction
                        if($this->db->commit()) {
                            header("Location:../layouts/mis_requisitos.php?message=Se asignaron correctamente los requisitos.");
                        }else {
                            header("Location:../layouts/mis_requisitos.php?message=No se efectuo el commit.");
                        }
                    }
                } catch (PDOException $e) {
                    $this->db->rollBack();
                    header("Location:../index.php?message=".$e->getMessage());
                }
            } 
        }

    }

    $radicar = new Radicar($objetoPDO);
    if(isset($_POST) && !empty($_POST)) {
        if(isset($_GET['create'])) {
            $radicar->radicar($_POST);
        }
        if(isset($_GET['list'])) {
            $radicar->asignarRequisitos($_POST);
        }
    }