<?php

class Conexion {
    
    //Definimos las constantes para la conexión
    const HOST = 'localhost';
    const DATABASE = 'MESA_AYUDA';
    const USER = 'root';
    const PASSWORD = 'Mattelsa.2018*';

    /**
     * Función que permite realizar la conexión a la base de datos
     * @param Object $objetoPDO
     */
    public function connect() {
        try{
            $stringConexion = 'mysql:host='.self::HOST.';dbname='.self::DATABASE;
            $objetoPDO = new PDO($stringConexion, self::USER, self::PASSWORD);
            
        }catch (PDOException $e) {
             echo "¡Error!: " . $e->getMessage();
             die();
        }
        return $objetoPDO;
    }
}