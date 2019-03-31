<?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include('../bd/database.php');
    class Radicar {
        
        public $db;
        
        function __construct($objetoPDO) {
            $this->db = $objetoPDO;
        }

        public function radicar($data) {
            
            try {

                $query = "INSERT INTO REQUISITO (FKAREA) VALUES (".$data['radicado-area'].")";
                $sth = $this->db->prepare($query);
                $resultado = $sth->execute();

            } catch (PDOExeption $e) {
                echo $e->getMessage();
            }

            if($resultado === true){
                echo "Se creó el requisito";
            }else{
                echo "La consulta ha producido un error, revisala";
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

    }

    $radicar = new Radicar($objetoPDO);
    if(isset($_POST) && !empty($_POST)) {
        if(isset($_GET['create'])) {
            $radicar->radicar($_POST);
        }
        echo "<pre>";
        var_dump($_POST);
        var_dump($_GET);
        echo "</pre>";
        die;
    }