<?php 

class Login {

    public $usuario;
    public $password;
    

    function Login($usuario, $password) {
        $this->usuario = $usuario;
        $this->password = $password;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getPassword() {
        return $this->password;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    
    function setPassword($password) {
        $this->password = $password;
    }
}
