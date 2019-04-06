<?php
if(!class_exists('Conexion')) {
    include('Conexion.php');
}
if(!class_exists('Area')) {
    include('../models/Area.php');
}
class EstadoController {
    
    public function getEstados() {
        
        $query = "SELECT `IDESTADO`, `NOMBRE` FROM `ESTADO`";
        
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
}
