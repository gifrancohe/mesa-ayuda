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
  <body>
    <div class="navbar-fixed">
      <nav class="grey darken-4">
        <div class="container">
          <div class="nav-wrapper">
            <a href="#" class="brand-logo">Mesa de Ayuda</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
              <?php if(isset($_SESSION['id'])) :?>
                <li><a href="sass.html">Administrar usuarios </a></li>
                <li><a href="badges.html">Gestión areas y Empleados</a></li>
                <li><a href="collapsible.html">Consultas e Informes</a></li>
                <li><a href="login/login.php">Cerrar Sesión</a></li>
              <?php else: ?>
                <li><a href="login/login.php">Iniciar Sesión</a></li>
              <?php endif;?>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    
    