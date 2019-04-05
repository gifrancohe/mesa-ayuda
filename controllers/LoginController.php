<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
if(!class_exists('Conexion')) {
    include('Conexion.php');
}
if(!class_exists('Login')) {
    include('../models/Login.php');
}

class LoginController {
    
    public $login;

    public function LoginController($login = null) {
        $this->login = $login;
    }

    public function createUser() {
        
        $usuario = $this->login->getUsuario();
        $password = $this->login->getPassword();

        if(!empty($usuario) && !empty($password)) {

            $password = password_hash($password, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO `USUARIO` ( `USUARIO`, `PASSWORD` ) VALUES ('".$usuario."', '".$password."')";
            
            $conn = new Conexion();
            $db = $conn->connect();
    
            try {
                $sth = $db->prepare($query);
                $resultado = $sth->execute();
                if($resultado) {
                    return $db->lastInsertId();
                }else {
                    return $sth->errorInfo();
                }
                $sth->closeCursor();

            } catch (PDOException $e) {
                echo "<pre>";
                print_r($e->getMessage());
                echo "</pre>";
                die;
            }
        }
        
    }

    public function login() {

        $usuario = $this->login->getUsuario();
        $password = $this->login->getPassword();
        
        if(!empty($usuario) && !empty($password)) {

            $query = "SELECT `IDUSUARIO`, `USUARIO`, `PASSWORD` FROM `USUARIO` WHERE `USUARIO` = '".$usuario."'";
            
            $conn = new Conexion();
            $db = $conn->connect();
    
            try {
                $sth = $db->prepare($query);
                $resultado = $sth->execute();
                $resultado = $sth->fetch(PDO::FETCH_ASSOC);
                $sth->closeCursor();

                if(!empty($resultado) && $resultado['USUARIO'] == $usuario && password_verify($password, $resultado['PASSWORD'])) {
                    session_start();
                    $query = "SELECT * FROM `USUARIO` 
                    LEFT JOIN `EMPLEADO` ON `EMPLEADO`.FKUSUARIO = `USUARIO`.IDUSUARIO
                    WHERE `USUARIO`.IDUSUARIO = ".$resultado['IDUSUARIO'];
                    $sth = $db->prepare($query);
                    $resultado = $sth->execute();
                    $resultado = $sth->fetch(PDO::FETCH_ASSOC);
                    $sth->closeCursor();

                    if(!empty($resultado)) {
                        foreach ($resultado as $key => $data) {
                            $_SESSION[$key] = $data;
                        }
                        //Se redirecciona al index
                        header("Location:../index.php");
                    }else {
                        header("Location:../views/login/login.php?message=No se encontro un empleado asociado al usuario.");
                    }
                }else{
                    header("Location:../views/login/login.php?message=El usuario o contraseña esta incorrecto.");
                }
            } catch (PDOException $e) {
                echo "<pre>";
                print_r($e->getMessage());
                echo "</pre>";
                return false;
            }
        }else {
            header("Location:../views/login/login.php?message=No diligencio usuario y contraseña.");
        }
    }
}

if(!empty($_POST)) {
    $login = new Login($_POST['user'], $_POST['password']);
    $controller = new LoginController($login);
    if($_GET['login']) {
        $controller->login();
    } 
}
