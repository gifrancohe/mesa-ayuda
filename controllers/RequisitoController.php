<?php
    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    session_start();
    if(!class_exists('Conexion')) {
        include('Conexion.php');
    }
    if(!class_exists('Requisito')) {
        include('../models/Requisito.php');
    }
    if(!class_exists('DetalleRequisito')) {
        include('../models/DetalleRequisito.php');
    }
    if(!class_exists('DetalleRequisitoController')) {
        include('DetalleRequisitoController.php');
    }

    class RequisitoController {
        
        public $requisito;
        public $text;

        public function RequisitoController($requisito = null, $text = null) {
            $this->requisito = $requisito;
            $this->text = $text;
        }

        public function crear() {
            
            $fkarea = $this->requisito->getFkarea();
            $fkestado = $this->requisito->getFkestado();

            $query = "INSERT INTO REQUISITO ( FKAREA, FKESTADO ) VALUES ('".$fkarea."', ".$fkestado.")";
            
            $conn = new Conexion();
            $db = $conn->connect();

            try {
                $sth = $db->prepare($query);
                $resultado = $sth->execute();
                $id = $db->lastInsertId();
                if($resultado && $id) {
                    $sth->closeCursor();
                    //Creamos el objeto con el detalle del requisito
                    $detalle = new DetalleRequisito(
                        date('Y-m-d h:i:s'),
                        $this->text,
                        $_SESSION['IDEMPLEADO'],
                        $id,
                        1
                    );

                    $detaCtrl = new DetalleRequisitoController($detalle);
                    $detaResult = $detaCtrl->crear();

                    if($detaResult) {
                        header("Location:../views/requisito/crear.php?message=Se creó el requisito correctamente.");
                    }else {
                        $this->borrarRequisito($id);
                        header("Location:../views/requisito/crear.php?error=Ocurrio un error update. Error: ".$detaResult[2]);
                    }
                   
                }else {
                    $error = $sth->errorInfo();
                    $sth->closeCursor();
                    header("Location:../views/requisito/crear.php?error=Ocurrio un error update. Error: ".$error[2]);
                }
            } catch (PDOException $e) {
                header("Location:../views/requisito/crear.php?error=Ocurrio un error update. Error: ".$e->getMessage());
            }
        }


        public function borrarRequisito($id) {
            $conn = new Conexion();
            $db = $conn->connect();
            
            $query = "SET GLOBAL FOREIGN_KEY_CHECKS=0;";
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            $sth->closeCursor();
            
            $query = "DELETE FROM `REQUISITO` WHERE `IDREQ` =".$id;
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            $sth->closeCursor();
            
            return $resultado;
        }

       /**
         * Función que permite asignar los requisitos a un empleado especifico
         */
        public function asignar($data) {
            if(!empty($data)) {
                try {
                    $conn = new Conexion();
                    $db = $conn->connect();

                    $observacion = $data['Requisito']['requisito'];
                    $empleadoAsignado = $data['Requisito']['empleado'];

                    $error = false;
                    
                    foreach( $data['Requisitos'] as $key => $req) {
                        // Insertamos el detalle del requisito
                        $detalle = new DetalleRequisito(
                            date('Y-m-d h:i:s'),
                            $observacion,
                            $_SESSION['IDEMPLEADO'],
                            $key,
                            2,
                            $empleadoAsignado
                        );
                        
                        $detaCtrl = new DetalleRequisitoController($detalle);
                        $detaResult = $detaCtrl->crear();
                        
                        if($detaResult) {
                            $query = "UPDATE `REQUISITO` SET 
                            `FKESTADO` = 2
                            WHERE `IDREQ` = ".$key;
                            
                            $conn = new Conexion();
                            $db = $conn->connect();

                            $sth = $db->prepare($query);
                            $resultado = $sth->execute();
                            $sth->closeCursor();

                            if(!$resultado) {
                                $error = true;
                            }

                        }else {
                            $error = true;
                        }
                        
                    }
                    if($error) {
                        header("Location:../views/requisito/asignar.php?error=Ocurrio un error al asignar los requisitos.");
                    }else {
                        header("Location:../views/requisito/asignar.php?message=Se asignó correctamente.");
                    }
                } catch (PDOException $e) {
                    $this->db->rollBack();
                    header("Location:../index.php?message=".$e->getMessage());
                }
            }else {
                header("Location:../views/requisito/asignar.php?error=No se tiene data para asignar.");
            } 
        }

        public function solucionar($data) {
            if(!empty($data)) {
                try {
                    $conn = new Conexion();
                    $db = $conn->connect();

                    $observacion = $data['Requisito']['requisito'];
                    $estadoAsignado = $data['Requisito']['estado'];

                    $error = false;
                    
                    foreach( $data['Requisitos'] as $key => $req) {
                        // Insertamos el detalle del requisito
                        $detalle = new DetalleRequisito(
                            date('Y-m-d h:i:s'),
                            $observacion,
                            $_SESSION['IDEMPLEADO'],
                            $key,
                            $estadoAsignado
                        );
                        
                        $detaCtrl = new DetalleRequisitoController($detalle);
                        $detaResult = $detaCtrl->crear();
                        
                        if($detaResult) {
                            $query = "UPDATE `REQUISITO` SET 
                            `FKESTADO` = ".$estadoAsignado."
                            WHERE `IDREQ` = ".$key;
                            
                            $conn = new Conexion();
                            $db = $conn->connect();

                            $sth = $db->prepare($query);
                            $resultado = $sth->execute();
                            $sth->closeCursor();

                            if(!$resultado) {
                                $error = true;
                            }

                        }else {
                            $error = true;
                        }
                        
                    }
                    if($error) {
                        header("Location:../views/requisito/solucionar.php?error=Ocurrio un error al solucionar los requisitos.");
                    }else {
                        header("Location:../views/requisito/solucionar.php?message=Caso Gestionado.");
                    }
                } catch (PDOException $e) {
                    $this->db->rollBack();
                    header("Location:../index.php?message=".$e->getMessage());
                }
            }else {
                header("Location:../views/requisito/solucionar.php?error=No se tiene data para solucionar.");
            } 
        }


        public function editar($id) {
            
            $area = $this->requisito->getFkarea();
            $estado = $this->requisito->getFkestado();

            
            $query = "UPDATE `REQUISITO` SET 
            `FKAREA`='".$area."',  `FKESTADO` = ".$estado."
            WHERE `IDREQ` = ".$id;
            
                    
            $conn = new Conexion();
            $db = $conn->connect();

            try {
                
                $sth = $db->prepare($query);
                $resultado = $sth->execute();
                $sth->closeCursor();
                return $resultado;

            } catch (PDOException $e) {
                header("Location:../../views/requisito/asignar.php?error=".$e->getMessage());
            }
        }

        public function getRequisito($id) {
            
           $query = "SELECT * FROM `REQUISITO`
            WHERE `IDREQ` = ".$id;
            
            $conn = new Conexion();
            $db = $conn->connect();

            try {
                $requisito = null;
                $sth = $db->prepare($query);
                $resultado = $sth->execute();
                if($resultado){
                    $requisito = $sth->fetchAll(PDO::FETCH_ASSOC);
                }
                $sth->closeCursor();
                
                return $requisito;

            } catch (PDOException $e) {
                header("Location:../../views/requisito/asignar.php?error=".$e->getMessage());
            }
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
            AND `REQ`.FKESTADO = 1";
            
            $conn = new Conexion();
            $db = $conn->connect();

            $sth = $db->prepare($query);
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
         * Retorna los requisitos asignados a la persona que esta en la sessión
         * @param Array $requisitos
         */
        public function getMisrequisitos() {
            
            $idUser = $_SESSION['IDEMPLEADO'];

            $query = "SELECT  
                `REQ`.IDREQ AS IDREQ,
                `ESTADO`.`NOMBRE` AS ESTADO,
                `DET`.IDDETALLEREQ AS IDDETALLE,
                `DET`.FECHA AS FECHA,
                `AREA`.`IDAREA` AS IDAREA,
                `AREA`.`NOMBRE` AS NOMBRE_AREA,
                `EMPLEADO`.`IDEMPLEADO` AS IDEMPLEADO,
                `EMPLEADO`.`NOMBRE` AS NOMBRE_EMPLEADO
            FROM `REQUISITO` AS `REQ`
            INNER JOIN `ESTADO` ON `ESTADO`.`IDESTADO` = `REQ`.FKESTADO
            INNER JOIN `DETALLEREQ` AS `DET` ON `DET`.FKREQ = `REQ`.IDREQ
            INNER JOIN `AREA` ON `AREA`.`IDAREA` = `REQ`.FKAREA
            INNER JOIN `EMPLEADO` ON `EMPLEADO`.`IDEMPLEADO` = `DET`.FKEMPLEASIG
            WHERE `REQ`.FKESTADO = 2 AND `EMPLEADO`.`IDEMPLEADO` = ".$idUser.";";
            
            $conn = new Conexion();
            $db = $conn->connect();

            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            $requisitos = [];
            if($resultado !== false){
                $requisitos = $sth->fetchAll(PDO::FETCH_ASSOC);
            }

            return $requisitos;
        }

        /**
         * Retorna los estados para solucionar un requisito
         * @param Array $estados
         */
        public function getEstados() {
            
            $query = "SELECT * FROM ESTADO WHERE IDESTADO IN(3,4)";
            $sth = $this->db->prepare($query);
            $resultado = $sth->execute();

            $estados = [];
            if($resultado !== false){
                $estados = $sth->fetchAll(PDO::FETCH_ASSOC);
            }
            return $estados;
        }

        public function solucionarRequisitos($data) {
            if(!empty($data)) {
                try {
                    $this->db->beginTransaction();
                    
                    $fecha = date('Y-m-d h:i:s');
                    $estado = $data['radicado-estado']; //Estado Asignado
                    $texto = $data['radicado-text']; //Texto que ingreso el usuario
                    $id_empleado = $_SESSION['IDEMPLEADO']; //Id del empleado en la sessión actual
                    
                    foreach( $data['requisitos'] as $key => $req) {
                        
                        //Cambiamos el estado del requisito
                        $query = "UPDATE `REQUISITO` SET `FKESTADO`= ".$estado." WHERE `IDREQ`= ".$key." ";
                        $sth = $this->db->prepare($query);
                        $resultado = $sth->execute();
                        $sth->closeCursor();

                        // Insertamos el detalle del requisito
                        $query = "INSERT INTO DETALLEREQ (FECHA, OBSERVACION, FKEMPLE, FKREQ, FKESTADO, FKEMPLEASIG) 
                        VALUES ('".$fecha."', '".$texto."', ".$id_empleado.", ".$key.", ".$estado.", ".$id_empleado.")";
                        $sth = $this->db->prepare($query);
                        $resultado = $sth->execute();
                        $sth->closeCursor();
                        
                        // commit the transaction
                        if($this->db->commit()) {
                            header("Location:../layouts/solucion_requisitos.php?message=Se guardaron todos los cambios.");
                        }else {
                            header("Location:../layouts/solucion_requisitos.php?message=No se efectuo el commit.");
                        }
                    }
                } catch (PDOException $e) {
                    $this->db->rollBack();
                    header("Location:../index.php?message=".$e->getMessage());
                }
            }
        }

    }

    if(!empty($_POST['Requisito'])) {
        if($_GET['create']) {
            
            $requisito = new Requisito(
                $_POST['Requisito']['area'],
                1 //Estado inicial del requisito (Radicado)
            );
        
            $requisitoCrtl = new RequisitoController($requisito, $_POST['Requisito']['requisito']);
            $requisitoCrtl->crear();
        }
        if($_GET['solu']) {
            $requisitoCrtl = new RequisitoController();
            $requisitoCrtl->solucionar($_POST);
            echo "<pre>";
            var_dump($_POST);
            echo "</pre>";
            die;
        }
        if($_GET['assign']) {
            $requisitoCrtl = new RequisitoController();
            $requisitoCrtl->asignar($_POST);
        }
    }