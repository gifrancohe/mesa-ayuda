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

    if(!class_exists('ReporteController')) {
        include('../../controllers/ReporteController.php');
    }
   
    $reporte = new ReporteController();
    $empleados = $reporte->reporteEmpleados();
?>
<main>
    <div class="container" style="margin-top: 20px;">
        <div class="row card s12 m12" style="padding: 15px;">
            <div>
                <h5 class="center-align teal-text text-lighten-1">Lista de Empleados, Lideres y Áreas</h5>
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
            <div class="table-areas" id="tabla-areas">
                <table class="centered responsive-table">
                    <thead>
                        <tr>
                            <th>NOMBRE</th>
                            <th>LIDER</th>
                            <th>ÁREA</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($empleados as $key => $emple):?>
                            <tr>
                                <td><?= utf8_encode($emple['NOMBRE']); ?></td>
                                <td><?= utf8_encode($emple['LIDER']); ?></td>
                                <td><?= utf8_encode($emple['AREA']); ?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => { 
            var elems = document.querySelectorAll('select');
            var instances = M.FormSelect.init(elems);

            var elems = document.querySelectorAll('.fixed-action-btn');
            var instances = M.FloatingActionButton.init(elems, options);

        }, false);
    </script>
</main>
 <?php  
 include("../../layouts/footer.php");