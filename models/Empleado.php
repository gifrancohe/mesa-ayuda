<?php

class Empleado {

    public $idempleado;
    public $nombre;
    public $telefono;
    public $cargo;
    public $email;
    public $fkarea;
    public $fkemple;
    public $fkusuario;


    public function Empleado($nombre, $telefono, $cargo, $email, $fkarea, $fkemple = null, $fkusuario) {
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->cargo = $cargo;
        $this->email = $email;
        $this->fkarea = $fkarea;
        $this->fkemple = $fkemple;
        $this->fkusuario = $fkusuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getCargo() {
        return $this->cargo;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFkarea() {
        return $this->fkarea;
    }

    public function getFkemple() {
        return $this->fkemple;
    }

    public function getFkusuario() {
        return $this->fkusuario;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    public function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setFkarea($area) {
        $this->fkarea = $area;
    }

    public function setFkemple($empleado) {
        $this->fkemple = $empleado;
    }

    public function setFkusuario($usuario) {
        $this->fkusuario = $usuario;
    }
    
}