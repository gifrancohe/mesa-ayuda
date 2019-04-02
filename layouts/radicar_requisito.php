<?php 
    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    include('bd/database.php');
    include('controllers/RadicarController.php');

    $radicar = new Radicar($objetoPDO);
?>
<div class="container" style="margin-top: 80px;">
    <div class="row card">
        <?php if(isset($_GET['message'])): ?>
            <div class="card-panel teal lighten-2" id="card-response-message">
                <p class="white-text" id="response-message"><?= $_GET['message'] ?></p>
                <i class="tiny material-icons white-text" id="clear-message" onclick="clearMessage()">clear</i>
            </div>
        <?php endif;?>
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
    
    /**
     * Función para ocultar el mensaje que llegué al crear una notificación
     */
    function clearMessage() {
        var s = document.getElementById('card-response-message').style;
        s.opacity = 1;
        removeParam();
        (function fade(){(s.opacity-=.1)<0?s.display="none":setTimeout(fade,40)})();
        return true;
    }
    /**
     * Función para remover los parametro que lleguen por url
     */
    function removeParam()
    {
        var url = document.location.href;
        var urlparts = url.split('?');
        if (urlparts.length >= 1) {
            var urlBase = urlparts.shift(); 
            var queryString = urlparts.join("?"); 
            window.history.pushState('',document.title,urlBase); //Se agrega la url base a la url del navegador
        }
        return true;
    }
    
</script>