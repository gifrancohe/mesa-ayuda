<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <!--Import style.css-->
    <link type="text/css" rel="stylesheet" href="../../css/style.css"  media="screen,projection"/>
    
    

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!--Favicon Icon-->
    <link rel="shortcut icon" href="../../images/table.ico" />

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
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

    <!-- Dropdown Structure -->
    <ul id="dropdown1" class="dropdown-content">
      <li><a href="../../views/reporte/areas.php">Reporte de Àreas</a></li>
      <li><a href="../../views/reporte/empleados.php">Reporte Empleados</a></li>
      <li><a href="../../views/reporte/requisitos.php">Reporte requisitos</a></li>
    </ul>
    <div class="navbar-fixed">
      <nav class="grey darken-4">
        <div class="container">
          <div class="nav-wrapper">
            <a href="../../views/requisito/crear.php" class="brand-logo">Mesa de Ayuda</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
              
              <?php if(!empty($_SESSION['IDAREA']) && $_SESSION['IDAREA'] == 1):?>
                <li><a href="../../views/empleado/lista.php">Administrar usuarios </a></li>
                <li><a href="../../views/area/lista.php">Gestión Áreas </a></li>
              <?php endif;?>
              <?php if(!empty($_SESSION['IDAREA'])):?>
                <!-- Dropdown Trigger -->
                <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Consultas e Informes<i class="material-icons right">arrow_drop_down</i></a></li>
                <li><a href="../../views/requisito/asignar.php">Mis requisitos</a></li>
              <?php else :?>
                <li><a href="../../views/requisito/solucionar.php">Mis requisitos</a></li>
              <?php endif;?>
              <li><a href="../../views/login/cerrar_sesion.php" class='btn btn.floating waves-effect waves-light btn'><?= $name; ?><i class="tiny material-icons right">close</i></a></li>
              
            </ul>
          </div>
        </div>
      </nav>
    </div>
    <script
  src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
  crossorigin="anonymous"></script>
  <script>
    $(document).ready(function(){
      $(".dropdown-trigger").dropdown();
    });
  </script>
    
    