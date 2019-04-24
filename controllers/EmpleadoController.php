<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

if(!class_exists('Conexion')) {
    include('Conexion.php');
}
if(!class_exists('Login')) {
    include('../models/Login.php');
}
if(!class_exists('LoginController')) {
    include('LoginController.php');
}
if(!class_exists('Empleado')) {
    include('../models/Empleado.php');
}


class EmpleadoController {
    
    public $empleado;

    public function EmpleadoController($empleado = null) {
        $this->empleado = $empleado;
    }

    public function crear() {
        
        $nombre = $this->empleado->getNombre();
        $telefono = $this->empleado->getTelefono();
        $cargo = $this->empleado->getCargo();
        $email = $this->empleado->getEmail();
        $area = $this->empleado->getFkarea();
        $empleado = $this->empleado->getFkemple() ? $this->empleado->getFkemple(): null;
        $usuario = $this->empleado->getFkusuario();

        if(!empty($empleado)) {
            $query = "INSERT INTO `EMPLEADO` ( `NOMBRE`, `TELEFONO`, `CARGO`, `EMAIL`, `FKAREA`, `FKEMPLE`, `FKUSUARIO`) 
            VALUES ('".$nombre."', '".$telefono."', '".$cargo."', '".$email."', ".$area.", ".$empleado.", ".$usuario.")";    
        }else {
            $query = "INSERT INTO `EMPLEADO` ( `NOMBRE`, `TELEFONO`, `CARGO`, `EMAIL`, `FKAREA`, `FKUSUARIO`) 
            VALUES ('".$nombre."', '".$telefono."', '".$cargo."', '".$email."', ".$area.", ".$usuario.")";
        }

        
        
        $conn = new Conexion();
        $db = $conn->connect();

        try {
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            if($resultado) {
                $sth->closeCursor();
                header("Location:../views/empleado/crear.php?message=Se creó el empleado correctamente.");
            }else {
                $error = $sth->errorInfo();
                $sth->closeCursor();
                header("Location:../views/empleado/crear.php?error=Ocurrio un error update. Error: ".$error[2]);
            }

        } catch (PDOException $e) {
            header("Location:../views/empleado/crear.php?error=".$e->getMessage());
        }
        
        
    }

    public function getEmpleados() {
        $query = "SELECT `IDEMPLEADO`, `NOMBRE` FROM `EMPLEADO`";
        
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
            `EMPLEADO`.*,
            `USUARIO`.*,
            `AREA`.`IDAREA`,
            `AREA`.`NOMBRE` AS `NOMBRE_AREA`
        FROM `EMPLEADO`
        LEFT JOIN `USUARIO` ON `USUARIO`.IDUSUARIO = `EMPLEADO`.FKUSUARIO
        LEFT JOIN `AREA` ON `AREA`.`IDAREA` = `EMPLEADO`.`FKAREA`
        ORDER BY `EMPLEADO`.`IDEMPLEADO`";
        
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
            `EMPLEADO`.`IDEMPLEADO`,
            `EMPLEADO`.`NOMBRE`,
            `EMPLEADO`.`TELEFONO` AS `TELÉFONO`,
            `EMPLEADO`.`CARGO`,
            `EMPLEADO`.`EMAIL`,
            `USUARIO`.`IDUSUARIO`,
            `USUARIO`.`USUARIO`,
            `USUARIO`.`PASSWORD`,
            (SELECT `EMPLE`.`NOMBRE` FROM `EMPLEADO` AS `EMPLE` WHERE `EMPLE`.`IDEMPLEADO` = `EMPLEADO`.`FKEMPLE` ) AS `LIDER`,
            `AREA`.`IDAREA`,
            `AREA`.`NOMBRE` AS `AREA`
        FROM `EMPLEADO`
        INNER JOIN `USUARIO` ON `USUARIO`.IDUSUARIO = `EMPLEADO`.FKUSUARIO
        INNER JOIN `AREA` ON `AREA`.`IDAREA` = `EMPLEADO`.`FKAREA`
        WHERE `EMPLEADO`.`IDEMPLEADO` = ".$id."
        ORDER BY `EMPLEADO`.`IDEMPLEADO`";
        
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
        
        $nombre = $this->empleado->getNombre();
        $telefono = $this->empleado->getTelefono();
        $cargo = $this->empleado->getCargo();
        $email = $this->empleado->getEmail();
        $area = $this->empleado->getFkarea();
        
        $query = "UPDATE `EMPLEADO` SET 
        `NOMBRE`='".$nombre."',  `TELEFONO` = '".$telefono."', `CARGO` = '".$cargo."', `EMAIL` = '".$email."', `FKAREA`=".$area." 
        WHERE `IDEMPLEADO` = ".$id;
        
        $conn = new Conexion();
        $db = $conn->connect();

        try {
            $sth = $db->prepare($query);
            $resultado = $sth->execute();
            if($resultado) {
                $sth->closeCursor();
                header("Location:../views/empleado/lista.php?message=Se actualizo correctamente el usuario ".$nombre);
            }else {
                $error = $sth->errorInfo();
                $sth->closeCursor();
                header("Location:../views/empleado/editar.php?error=Ocurrio un error editando. Error: ".$error[2]);
            }

        } catch (PDOException $e) {
            header("Location:../views/empleado/editar.php?error=".$e->getMessage());
        }
        
        
    }
}

if(!empty($_POST['Empleado'])) {
    if($_GET['create']) {
        
        $login = new Login($_POST['Empleado']['usuario'], $_POST['Empleado']['password']);
        $loginCtrl = new LoginController($login);
        $idUser = $loginCtrl->createUser();

        # Check if your variable is an integer
        if ( is_array($idUser) ) {
            $error = $idUser[2];
            header("Location:../views/empleado/crear.php?error=Ocurrio un error al crear el usuario. Error: ".$error);
        }else{
            $empleado = new Empleado(
                $_POST['Empleado']['nombre'], 
                $_POST['Empleado']['telefono'],
                $_POST['Empleado']['cargo'], 
                $_POST['Empleado']['email'],
                $_POST['Empleado']['fkarea'], 
                $_POST['Empleado']['fkemple'] ? $_POST['Empleado']['fkemple']:null,
                $idUser
            );
    
            $emplCrtl = new EmpleadoController($empleado);
            $emplCrtl->crear();
        }
        
        
    }
    if($_GET['edit']) {
        $empleado = new Empleado(
            $_POST['Empleado']['nombre'], 
            $_POST['Empleado']['telefono'],
            $_POST['Empleado']['cargo'], 
            $_POST['Empleado']['email'],
            $_POST['Empleado']['area'], 
            $_POST['Empleado']['lider'] ? $_POST['Empleado']['lider']:null 
        );

        $login = new Login($_POST['Empleado']['usuario'], $_POST['Empleado']['password']);
        $loginCtrl = new LoginController($login);
        $idUser = $loginCtrl->updateUser($_POST['Empleado']['idusuario']);

        $emplCrtl = new EmpleadoController($empleado);
        $emplCrtl->editar($_POST['Empleado']['idempleado']);
    }
}
