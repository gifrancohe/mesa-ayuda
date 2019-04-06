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

    $idEmpleado = $_GET['id'];
    $area = new AreaController();
    $empleCtrl = new EmpleadoController();
    $empleado = $empleCtrl->ver($idEmpleado);
?>
<main>
    <div class="container" style="margin-top: 20px;">
        <div class="row card s12 m12" style="padding: 15px;">
            <div>
                <h5 class="center-align teal-text text-lighten-1">Editar Usuario</h5>
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
            <form class="col s12" style="padding: 50px;" id="form-edit-empleado" name="Empleado[form-edit-empleado]" onsubmit="return validateForm()" action="../../controllers/EmpleadoController.php?edit=1" method="post">
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input id="idempleado" name="Empleado[idempleado]" value="<?= $empleado['IDEMPLEADO'] ?>" type="hidden" class="validate-custom">
                        <input placeholder="Ingresa un nombre" id="nombre" name="Empleado[nombre]" value="<?= $empleado['NOMBRE'] ?>" type="text" class="validate-custom">
                        <label for="nombre">Nombre</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input placeholder="Ingresa un teléfono" id="telefono" name="Empleado[telefono]" value="<?= $empleado['TELÉFONO'] ?>" type="text" class="validate-custom">
                        <label for="telefono">Teléfono</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input placeholder="Ingresa un cargo" id="cargo"  name="Empleado[cargo]" value="<?= $empleado['CARGO'] ?>" type="text" class="validate-custom">
                        <label for="cargo">Cargo</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input placeholder="Ingresa un email" id="email" name="Empleado[email]" value="<?= $empleado['EMAIL'] ?>" type="email" class="validate-custom">
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 m6">
                        <select name="Empleado[area]">
                            <option value="" disabled>Escoge una opción</option>
                            <?php foreach ($area->getAreas() as $key => $area):?>
                                <?php if($area['IDAREA'] == $empleado['IDAREA']):?>
                                    <option value="<?= $area['IDAREA'] ?>" selected><?= utf8_encode($area['NOMBRE']); ?></option>
                                <?php else:?>
                                    <option value="<?= $area['IDAREA'] ?>"><?= utf8_encode($area['NOMBRE']); ?></option>
                                <?php endif; ?>
                            <?php endforeach;?>
                        </select>
                        <label>Área usuario</label>
                    </div>

                    <div class="input-field col s12 m6">
                        <select name="Empleado[lider]">
                        <option value="" disabled>Escoge una opción</option>
                        <?php foreach ($empleCtrl->getEmpleados() as $key => $emple):?>
                            <?php if($emple['IDEMPLEADO'] == $empleado['IDEMPLEADO']):?>
                                <option value="<?= $emple['IDEMPLEADO'] ?>" selected><?= utf8_encode($emple['NOMBRE']); ?></option>
                            <?php else:?>
                                <option value="<?= $emple['IDEMPLEADO'] ?>"><?= utf8_encode($emple['NOMBRE']); ?></option>
                            <?php endif; ?>
                        <?php endforeach;?>
                        </select>
                        <label>Lider usuario</label>
                    </div>
                </div>
                <div class="input-field col s12 m12 center">
                    <button class="btn waves-effect waves-light" type="submit" name="Empleado[action]">Editar
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