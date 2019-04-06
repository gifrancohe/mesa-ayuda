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
    if(!class_exists('EmpleadoController')) {
        include('../../controllers/EmpleadoController.php');
    }
    if(!class_exists('RequisitoController')) {
        include('../../controllers/RequisitoController.php');
    }
    $empleCtrl = new EmpleadoController();
    $reqCtrl = new RequisitoController();
    
?>
<main>
    <div class="container" style="margin-top: 20px;">
        <div class="row card s12 m12" style="padding: 15px;">
            <div>
                <h5 class="center-align teal-text text-lighten-1">Asignar Requisito</h5>
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
            <form class="col s12" style="padding: 50px;" id="form-asignar-requisitos" name="form-asignar-requisitos" action="../../controllers/RequisitoController.php?assign=1" method="post">
                <div class="row col s12 m6">
                    <div class="row center">
                        <div class="input-field col s12 m12">
                            <i class="material-icons prefix">mode_edit</i>
                            <textarea id="icon_prefix2" class="materialize-textarea validate-custom" name="Requisito[requisito]"></textarea>
                            <label for="icon_prefix2">Asignar o Cancelar requisito: Mensaje</label>
                        </div>
                    </div>
                    <div class="row center">
                        <div class="input-field col s12 m6 center">
                            <select name="Requisito[empleado]">
                                <option value="" disabled selected>Selecciona el empleado</option>
                                <?php foreach($empleCtrl->getEmpleados() as $key => $emple):?>
                                    <option value="<?= $emple['IDEMPLEADO'];?>"> <?= utf8_encode($emple['NOMBRE']); ?> </option>
                                <?php endforeach; ?>
                            </select>
                            <label>Empleado Requisito</label>
                        </div>
                        <div class="input-field col s12 m6 center">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Asignar
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row col s12 m6">
                    <div class="table-requisitos" id="requisitos-asignar" style="padding:50px;">
                        <table class="centered responsive-table">
                            <thead>
                                <tr>
                                    <th>Requisito</th>
                                    <th>Área</th>
                                    <th>Fecha</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach($reqCtrl->getRequisitos() as $key => $requisito):?>
                                    <tr>
                                        <td><?= $requisito['IDREQ']; ?></td>
                                        <td><?= $requisito['NOMBRE']; ?></td>
                                        <td><?= $requisito['FECHA']; ?></td>
                                        <td><label><input type="checkbox" name="Requisitos[<?= $requisito['IDREQ'] ?>][]" /><span></span></label></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
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