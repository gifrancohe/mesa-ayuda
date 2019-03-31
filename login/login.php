<!DOCTYPE html>
<html>
  <head>
    <!--Import style.css-->
    <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/style.css"  media="screen,projection"/>

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
        header("Location:index.php");
    }
  ?>
  <body class="grey darken-3">
    <div class="container" id="container-login">
        <div class="row z-depth-5 white" id="row-login-form">
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
    <!--JavaScript at end of body for optimized loading-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  </body>
</html>