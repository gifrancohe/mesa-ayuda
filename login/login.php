<?php include("../layouts/header.php"); ?>
<div class="container" id="container-login">
    <div class="row z-depth-5" id="row-login-form">
        <form class="col s12" id="form-login" action="validar_usuario.php" method="post">
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">account_circle</i>
                    <input id="user" type="text" class="validate" name="user">
                    <label for="user">Usuario</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <i class="material-icons prefix">offline_pin</i>
                    <input id="password" type="password" class="validate" name="password">
                    <label for="password">Contraseña</label>
                </div>
            </div>
            <div class="row" id="button-submit-login">
                <button class="btn waves-effect waves-light" type="submit" name="action">Ingresar
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </form>
        
    </div>
</div>
<?php include("../layouts/footer.php"); ?>