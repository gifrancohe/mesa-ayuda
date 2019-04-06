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
    if(!class_exists('AreaController')) {
        include('../../controllers/AreaController.php');
    }
    $area = new AreaController();
?>
<main>
    <div class="container" style="margin-top: 20px;">
        <div class="row card s12 m12" style="padding: 15px;">
            <div>
                <h5 class="center-align teal-text text-lighten-1">Crear Requisito</h5>
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
            <form class="col s12" style="padding: 50px;" id="form-create-requisito" name="Requisito[form-create-requisito]" onsubmit="return validateForm()" action="../../controllers/RequisitoController.php?create=1" method="post">
                <div class="row center">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">mode_edit</i>
                        <textarea id="icon_prefix2" class="materialize-textarea validate-custom" name="Requisito[requisito]"></textarea>
                        <label for="icon_prefix2">Radicar requisito: Mensaje</label>
                    </div>
                </div>
                <div class="row center">
                    <div class="input-field col s12 m6 center">
                        <select name="Requisito[area]" class="validate-custom">
                            <option value="" disabled selected>Selecciona el área</option>
                            <?php foreach($area->getAreas() as $key => $area):?>
                                <option value="<?= $area['IDAREA'];?>"> <?= utf8_encode($area['NOMBRE']); ?> </option>
                            <?php endforeach; ?>
                        </select>
                        <label>Área Requisito</label>
                    </div>
                    <div class="input-field col s12 m6 center">
                        <button class="btn waves-effect waves-light" type="submit" name="Requisito[action]">Radicar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
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