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

    $idArea = $_GET['id'];
    $areaCtrl = new AreaController();
    $area = $areaCtrl->ver($idArea);
    $empleado = new EmpleadoController();
?>
<main>
    <div class="container" style="margin-top: 20px;">
        <div class="row card s12 m12" style="padding: 15px;">
            <div>
                <h5 class="center-align teal-text text-lighten-1">Editar Área</h5>
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
            <form class="col s12" style="padding: 50px;" id="form-edit-area" name="Empleado[form-edit-area]" onsubmit="return validateForm()" action="../../controllers/AreaController.php?edit=1" method="post">
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="idarea" name="Area[idarea]" value="<?= $area['IDAREA'] ?>" type="hidden" class="validate-custom">
                        <input placeholder="Ingresa un nombre" id="nombre" name="Area[nombre]" value="<?= $area['NOMBRE'] ?>" type="text" class="validate-custom">
                        <label for="nombre">Nombre</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select name="Area[fkemple]">
                            <option value="" disabled selected>Selecciona un Lider</option>
                            <?php foreach($empleado->getEmpleados() as $key => $emple):?>
                                <?php if($emple['IDEMPLEADO'] == $area['IDLIDER']):?>
                                    <option value="<?= $emple['IDEMPLEADO'] ?>" selected><?= utf8_encode($emple['NOMBRE']); ?></option>
                                <?php else:?>
                                    <option value="<?= $emple['IDEMPLEADO'] ?>"><?= utf8_encode($emple['NOMBRE']); ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                        <label>Lider área</label>
                    </div>
                </div>
                <div class="input-field col s12 m12 center">
                    <button class="btn waves-effect waves-light" type="submit" name="Area[action]">Editar
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="../../js/validar_formulario.js"></script>
    <script src="../../js/clear_message.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => { 
            var elems = document.querySelectorAll('select');
            var options = document.querySelectorAll('option');
            var instances = M.FormSelect.init(elems, options);
        });

        
    </script>
</main>
 <?php  
 include("../../layouts/footer.php");