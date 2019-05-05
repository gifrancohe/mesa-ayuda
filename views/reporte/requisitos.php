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

    /*include('../../models/Login.php');
    include('../../models/Empleado.php');
    include('../../models/Area.php');
    */
    include('../../controllers/AreaController.php');
    include('../../controllers/EmpleadoController.php');
    if(!class_exists('LoginController')) {
        include('../../controllers/LoginController.php');
    }

    $area = new AreaController();
    $empleado = new EmpleadoController();
    if(!class_exists('ReporteController')) {
        include('../../controllers/ReporteController.php');
    }
   
    $reporte = new ReporteController();
    $areas = $reporte->reporteAreas();
?>
<main>
    <div class="container" style="margin-top: 20px;">
        <div class="row card s12 m12" style="padding: 15px;">
            <div>
                <h5 class="center-align teal-text text-lighten-1">Reporte de Directores Sin Requisitos</h5>
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
            <form class="col s12" style="padding: 50px;" id="form-create-reporte" name="Area[form-create-reporte]" onsubmit="return validateForm()" action="../../controllers/ReporteController.php?create=1" method="post">
                <div class="row">
                    <div class="input-field col s12 m6">
                        <input type="text" class="datepicker" id="fecha-inicial" name="Reporte[fecha-inicial]" class="validate-custom">
                        <label for="fecha-inicial">Fecha Inicial</label>
                    </div>
                    <div class="input-field col s12 m6">
                        <input type="text" class="datepicker" id="fecha-final" name="Reporte[fecha-final]" class="validate-custom">
                        <label for="fecha-final">Fecha Final</label>
                    </div>
                </div>
                <div class="input-field col s12 m12 center">
                    <button class="btn waves-effect waves-light enviar"  type="button" name="Reporte[action]">Crear
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </form>
        </div>
        <div class="row card s12 m12 hidden" style="padding: 15px; display: none;" id="show-result">
            <table class="centered responsive-table">
                <thead>
                    <tr>
                        <th>DIRECTOR</th>
                        <th>TELÉFONO</th>
                        <th>EMAIL</th>
                        <th>ÁREA</th>
                    </tr>
                </thead>

                <tbody id="tbody-data">
                    
                </tbody>
            </table>
        </div>
    </div>
    <script src="../../js/validar_formulario.js"></script>
    <script src="../../js/clear_message.js"></script>
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script>
    $(document).ready(function(){
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoClose: true
        });
    });

    $(".enviar").click(function(e) {
        e.preventDefault();
        
        var fechaInicial = $("#fecha-inicial").val();
        var fechaFinal = $("#fecha-final").val();
        var datos = {"fechaInicial":fechaInicial, "fechaFinal":fechaFinal};

        $("#show-result").hide();
        $("#tbody-data").empty();

        $.ajax({
            url: "../../controllers/ReporteController.php?create=1",
            type: "POST",
            data: datos
        }).done(function(response){
            console.log(response);
            if(response !== "null" && response.length !== 0) {
                let tbody = "";
                let data = JSON.parse(response);
                data = Object.values(data);
                data.map(item => {
                    tbody += "<tr><td>"+item['NOMBRE']+"</td><td>"+item['TELEFONO']+"</td><td>"+item['EMAIL']+"</td><td>"+item['AREA']+"</td></tr>"; 
                });
                $("#tbody-data").append(tbody);
                $("#show-result").show();
            }
        });
    });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => { 
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems);
        }, false);

        
    </script>
</main>
 <?php  
 include("../../layouts/footer.php");