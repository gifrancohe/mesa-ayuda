<?php 
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
//Importamos el objeto que creamos con la conexión a la base de datos
include("../bd/database.php");

session_start();

//Recibimos las dos variables
$user = $_POST["user"];
$password = $_POST["password"];

$PDO = new database();
$objetoPDO = $PDO->connect();

$query = "SELECT * FROM EMPLEADO WHERE EMAIL='".$user."'";
$sth = $objetoPDO->prepare($query);
$resultado = $sth->execute();

if($resultado !== false){
    $dataEmpleado = $sth->fetch(PDO::FETCH_ASSOC);
}else{
    echo "La consulta ha producido un error, revisala";
}
 
if(!empty($dataEmpleado)) {
    foreach( $dataEmpleado as $key => $data){
        $_SESSION[$key] = $data;
    }
    header("Location:../index.php");
}else {
    echo "No se encotraron resultados";
}

