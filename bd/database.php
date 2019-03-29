<?php
//Creámos el objeto para la conexión a la base de datos
try{
    
    $objetoPDO = new PDO('mysql:host=localhost;dbname=MESA_AYUDA', 'root', 'Mattelsa.2018*');
    
}catch (PDOException $e) {
     echo "¡Error!: " . $e->getMessage();
     die();
}