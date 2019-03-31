<?php 
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    include('bd/database.php');
    include('controllers/RadicarController.php');

    $radicar = new Radicar($objetoPDO);
?>
<div class="container" style="margin-top: 80px;">
    <div class="row card">
        <form class="col s12" style="padding: 50px;" id="form-radicar" name="form-radicar" action="../controllers/RadicarController.php?create=1" method="post">
            <div class="row center">
                <div class="input-field col s12">
                    <i class="material-icons prefix">mode_edit</i>
                    <textarea id="icon_prefix2" class="materialize-textarea" name="radicado-text"></textarea>
                    <label for="icon_prefix2">Radicar requisito: Mensaje</label>
                </div>
            </div>
            <div class="row center">
                <div class="input-field col s12 m6 center">
                    <select name="radicado-area">
                        <option value="" disabled selected>Selecciona el área</option>
                        <?php foreach($radicar->obtenerAreas() as $key => $area):?>
                            <option value="<?= $area['IDAREA'];?>"> <?= utf8_encode($area['NOMBRE']); ?> </option>
                        <?php endforeach; ?>
                    </select>
                    <label>Área Requisito</label>
                </div>
                <div class="input-field col s12 m6 center">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Radicar
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => { 
        var elems = document.querySelectorAll('select');
        var instances = M.FormSelect.init(elems);
    }, false);

    
</script>