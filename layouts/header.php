<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <!--Import style.css-->
    <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/style.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/radicar_requisito.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/radicar_requisito.css"  media="screen,projection"/>
    

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>
  <body>
    <?php 
      $arrayName = explode(" ", $_SESSION['NOMBRE']);
      $name = "";
      foreach($arrayName as $key => $value) {
        $letter = substr($value, 0,1);
        $name = $name . $letter;
      }
    ?>

    <div class="navbar-fixed">
      <nav class="grey darken-4">
        <div class="container">
          <div class="nav-wrapper">
            <a href="#" class="brand-logo">Mesa de Ayuda</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
              
                <li><a href="sass.html">Administrar usuarios </a></li>
                <li><a href="badges.html">Gestión areas y Empleados</a></li>
                <li><a href="collapsible.html">Consultas e Informes</a></li>
                <li><a href="layouts/mis_requisitos.php">Mis requisitos</a></li>
                <li><a href="#" class='btn btn.floating pink lighten-1'><?= $name; ?></a></li>
              
            </ul>
          </div>
        </div>
      </nav>
    </div>
    
    