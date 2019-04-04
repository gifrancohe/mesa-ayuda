<?php 
    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    include('../bd/database.php');
    include('../controllers/RadicarController.php');

    session_start();
    if(!isset($_SESSION['IDEMPLEADO'])) {
        header("Location:login/login.php");
    }
    
    include("../layouts/header.php");
    $radicar = new Radicar($objetoPDO);

    $requisitos = $radicar->getMisrequisitos();//Se obtienen los requisitos en estado Asignado y que pertenencen al usuario en sessión
?>
<main>
<div class="container" style="margin-top: 20px;">
    <div class="row card s12 m12">
        <?php if(isset($_GET['message'])): ?>
            <div class="card-panel teal lighten-2" id="card-response-message">
                <p class="white-text" id="response-message"><?= $_GET['message'] ?></p>
                <i class="tiny material-icons white-text" id="clear-message" onclick="clearMessage()">clear</i>
            </div>
        <?php endif;?>
        <form class="col s12" id="form-mis-requisitos" name="form-mis-requisitos" action="../controllers/RadicarController.php?solu=1" method="post">
            <div class="row col s12 m6">
                    <div class="row center">
                        <div class="input-field col s6 m12">
                            <i class="material-icons prefix">mode_edit</i>
                            <textarea id="icon_prefix2" class="materialize-textarea" name="radicado-text"></textarea>
                            <label for="icon_prefix2">Solución total o Solución parcial: Mensaje</label>
                        </div>
                    </div>
                    <div class="row center">
                        <div class="input-field col s12 m6 center">
                            <select name="radicado-estado">
                                <option value="" disabled selected>Selecciona el estado</option>
                                <?php foreach($radicar->getEstados() as $key => $estado):?>
                                    <option value="<?= $estado['IDESTADO'];?>"> <?= utf8_encode($estado['NOMBRE']); ?> </option>
                                <?php endforeach; ?>
                            </select>
                            <label>Estado Requisito</label>
                        </div>
                        <div class="input-field col s12 m6 center">
                            <button class="btn waves-effect waves-light" type="submit" name="action">Solucionar
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
                            <?php foreach($requisitos as $key => $requisito):?>
                                <tr>
                                    <td><?= $requisito['IDREQ']; ?></td>
                                    <td><?= $requisito['NOMBRE_AREA']; ?></td>
                                    <td><?= $requisito['FECHA']; ?></td>
                                    <td><label><input type="checkbox" name="requisitos[<?= $requisito['IDREQ'] ?>][]" /><span></span></label></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="../js/clear_message.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', (event) => { 
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    }, false);

    
</script>
</main>
<?php 
    include("../layouts/footer.php");