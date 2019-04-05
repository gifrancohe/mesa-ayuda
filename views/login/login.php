<!DOCTYPE html>
<html>
  <head>
    <!--Import style.css-->
    <link type="text/css" rel="stylesheet" href="../../css/style.css"  media="screen,projection"/>

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>
  <?php 
    session_start();
    if(isset($_SESSION["IDEMPLEADO"])) {
        header("Location:../../index.php");
    }
    
    include("../../controllers/LoginController.php");
    include("../../models/Login.php");
  ?>
  <body class="grey darken-3">
    <div class="container" id="container-login">
        <div class="row z-depth-5 white" id="row-login-form">
            <form class="col s12" id="form-login" action="validar_usuario.php" onsubmit="return validateForm()" method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="user" type="text" name="user" class="validate-custom">
                        <label for="user" data-error="wrong" data-success="right">Usuario</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <i class="material-icons prefix">offline_pin</i>
                        <input id="password" type="password" name="password" class="validate-custom">
                        <label for="password" data-error="wrong" data-success="right">Contraseña</label>
                    </div>
                </div>
                <div class="row" id="button-submit-login">
                    <button class="btn waves-effect waves-light" type="submit" name="action" value="submit">Ingresar
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </form>
            
        </div>
    </div>
    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="../../js/validar_formulario.js"></script>
  </body>
</html>