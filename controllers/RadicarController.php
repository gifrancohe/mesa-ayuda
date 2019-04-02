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
                        $query = "INSERT INTO DETALLEREQ (FECHA, OBSERVACION, FKEMPLE, FKREQ, FKESTADO) 
                        VALUES ('".$fecha."', '".$data['radicado-text']."', ".$_SESSION['IDEMPLEADO'].", ".$id.", ".$estado.")";
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

        public function misRequisitos() {

        }

        public function obtenerEmpleados() {
            $query = "SELECT * FROM EMPLEADO";
            $sth = $this->db->prepare($query);
            $resultado = $sth->execute();

            if($resultado !== false){
                $empleados = $sth->fetchAll(PDO::FETCH_ASSOC);
            }

            if(empty($empleados)) {
                $empleados = [
                    1 => 'Sistemas',
                    2 => 'Gestión Humana',
                    3 => 'Mantenimiento'
                ];
            }
            return $empleados;
        }

    }

    $radicar = new Radicar($objetoPDO);
    if(isset($_POST) && !empty($_POST)) {
        if(isset($_GET['create'])) {
            $radicar->radicar($_POST);
        }
    }