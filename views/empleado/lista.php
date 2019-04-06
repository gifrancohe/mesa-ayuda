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
    if(!class_exists('AreaController')) {
        include('../../controllers/AreaController.php');
    }
    if(!class_exists('EmpleadoController')) {
        include('../../controllers/EmpleadoController.php');
    }
    if(!class_exists('LoginController')) {
        include('../../controllers/LoginController.php');
    }
    $empleado = new EmpleadoController();
    $empleados = $empleado->lista();
?>
<main>
    <div class="container" style="margin-top: 20px;">
        <div class="row card s12 m12" style="padding: 15px;">
            <div>
                <h5 class="center-align teal-text text-lighten-1">Lista de Usuarios</h5>
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
            <div class="table-usuarios" id="tabla-usuarios">
                <a class="waves-effect waves-light btn" href="crear.php"><i class="material-icons right">add_circle</i>Crear Usuario</a>
                <table class="centered responsive-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Área</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($empleados as $key => $emple):?>
                            <tr>
                                <td><?= utf8_encode($emple['IDEMPLEADO']); ?></td>
                                <td><?= utf8_encode($emple['USUARIO']); ?></td>
                                <td><?= utf8_encode($emple['NOMBRE']); ?></td>
                                <td><?= utf8_encode($emple['EMAIL']); ?></td>
                                <td><?= utf8_encode($emple['NOMBRE_AREA']); ?></td>
                                <td>
                                    <a href="<?= "ver.php?id=".$emple['IDEMPLEADO'];?>"><i class="material-icons">visibility</i></a>
                                    <a href="<?= "editar.php?id=".$emple['IDEMPLEADO'];?>"><i class="material-icons">edit</i></a> 
                                </td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../../js/validar_formulario.js"></script>
    <script src="../../js/clear_message.js"></script>
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