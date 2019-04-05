<?php

class LoginController {
    
    public $login;

    public function LoginController($login) {
        $this->login = $login;
    }

    public function createUser() {
        
        $usuario = $this->login->getUsuario();
        $password = $this->login->getPassword();

        if(!empty($usuario) && !empty($password)) {

            $password = password_hash($password, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO USUARIO ( USUARIO, PASSWORD ) VALUES ('".$usuario."', ".$password.")";
            
            $conn = new Conexion();
            $db = $conn->connect();
    
            try {
                $db->beginTransaction();
    
                $sth = $db->prepare($query);
                $resultado = $sth->execute();
                $sth->closeCursor();
    
                $db->commit();
                return true;
    
            } catch (PDOException $e) {
                $db->rollBack();
                echo "<pre>";
                print_r($e->getMessage());
                echo "</pre>";
                return false;
            }
        }
        
    }

    public function login() {

        $usuario = $this->login->getUsuario();
        $password = $this->login->getPassword();
        
        if(!empty($usuario) && !empty($password)) {

            $query = "SELECT USUARIO, PASSWORD FROM USUARIO WHERE USUARIO = '".$USUARIO."', PASSWORD = '".$PASSWORD."'";
            
            $conn = new Conexion();
            $db = $conn->connect();
    
            try {
                $sth = $db->prepare($query);
                $resultado = $sth->execute();
                $sth->closeCursor();

                $resultado = $sth->fetch(PDO::FETCH_ASSOC);

                if(!empty($resultado) && $resultado['USUARIO'] == $usuario && password_verify($password, $resultado['PASSWORD'])) {
                    session_start();
                    $query = "SELECT * FROM `USUARIO` 
                    LEFT JOIN EMPLEADO ON EMPLEADO.FKUSUARIO = USUARIO.IDUSUARIO
                    WHERE USUARIO.IDUSUARIO = ".$resultado['IDUSUARIO'];
                    $sth = $db->prepare($query);
                    $resultado = $sth->execute();
                    $resultado = $sth->fetch(PDO::FETCH_ASSOC);
                    $sth->closeCursor();

                    if(!empty($resultado)) {
                        foreach ($resultado as $key => $data) {
                            $_SESSION[$key] = $data;
                        }
                    }
                    header("Location:../index.php");
                }else{
                    return false;
                }
            } catch (PDOException $e) {
                echo "<pre>";
                print_r($e->getMessage());
                echo "</pre>";
                return false;
            }
        }
    }
}
