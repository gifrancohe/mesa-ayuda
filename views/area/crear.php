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
    include('../../controllers/AreaController.php');
    include('../../controllers/EmpleadoController.php');
    if(!class_exists('LoginController')) {
        include('../../controllers/LoginController.php');
    }

    $area = new AreaController();
    $empleado = new EmpleadoController();
?>
<main>
    <div class="container" style="margin-top: 20px;">
        <div class="row card s12 m12" style="padding: 15px;">
            <div>
                <h5 class="center-align teal-text text-lighten-1">Crear Área</h5>
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
            <form class="col s12" style="padding: 50px;" id="form-create-area" name="Area[form-create-area]" onsubmit="return validateForm()" action="../../controllers/AreaController.php?create=1" method="post">
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input placeholder="Ingresa un nombre" id="nombre" name="Area[nombre]" type="text" class="validate-custom">
                        <label for="nombre">Nombre</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <select name="Area[fkemple]">
                            <option value="" disabled selected>Selecciona un Lider</option>
                            <?php foreach($empleado->getEmpleados() as $key => $emple):?>
                                <option value="<?= $emple['IDEMPLEADO'];?>"> <?= utf8_encode($emple['NOMBRE']); ?> </option>
                            <?php endforeach; ?>
                        </select>
                        <label>Lider área</label>
                    </div>
                </div>
                <div class="input-field col s12 m12 center">
                    <button class="btn waves-effect waves-light" type="submit" name="Area[action]">Crear
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
            var instances = M.FormSelect.init(elems);
        }, false);

        
    </script>
</main>
 <?php  
 include("../../layouts/footer.php");