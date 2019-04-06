<?php 
    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    session_start();
    if(!isset($_SESSION['IDEMPLEADO'])) {
        header("Location:../../login/login.php");
    }
    include("../../layouts/header.php");
    if(!class_exists('Conexion')) {
        include('../../controllers/Conexion.php');
    }

    /*include('../../models/Login.php');
    include('../../models/Empleado.php');
    include('../../models/Area.php');
    */
    if(!class_exists('AreaController')) {
        include('../../controllers/AreaController.php');
    }
    if(!class_exists('EmpleadoController')) {
        include('../../controllers/EmpleadoController.php');
    }
    if(!class_exists('LoginController')) {
        include('../../controllers/LoginController.php');
    }
    $idempleado = $_GET['id'];
    $empleCtrl = new EmpleadoController();
    $empleado = $empleCtrl->ver($idempleado);
?>
<main>
    <div class="container" style="margin-top: 20px;">
        <div class="row card s12 m12" style="padding: 15px;">
            <div style="display: flex; justify-content: space-between;">
                <a class="waves-effect waves-light btn" href="lista.php"><i class="material-icons left">list</i>Lista Usuarios</a>
                <h5 class="center-align teal-text text-lighten-1">Usuario: <?= $empleado['USUARIO'] ?></h5>
                <a class="waves-effect waves-light btn" href="editar.php?id=<?= $idempleado;?>"><i class="material-icons right">edit</i>Editar Usuario</a>
            </div>
            <?php if(isset($_GET['message'])): ?>
                <div class="card-panel teal lighten-2" id="card-response-message">
                    <p class="white-text" id="response-message"><?= $_GET['message'] ?></p>
                    <i class="tiny material-icons white-text" id="clear-message" onclick="clearMessage()">clear</i>
                </div>
            <?php endif;?>
            <?php if(isset($_GET['error'])): ?>
                <div class="card-panel red lighten-1" id="card-response-message">
                    <p class="white-text" id="response-message"><?= $_GET['error'] ?></p>
                    <i class="tiny material-icons white-text" id="clear-message" onclick="clearMessage()">clear</i>
                </div>
            <?php endif;?>
            <div class="table-usuario" id="tabla-usuario">
                <table class="responsive-table striped">
                    <?php foreach($empleado as $key => $value):?>
                        <tr>
                            <td><b><?= $key; ?></b></td>
                            <td><?= $value ? utf8_decode($value) : 'Sin definir'; ?></td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>
</main>
 <?php  
 include("../../layouts/footer.php");