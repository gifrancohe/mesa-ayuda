<?php 
    session_start();
    if(!isset($_SESSION['IDEMPLEADO'])) {
        header("Location:views/login/login.php");
    }
    include("layouts/header.php");
    include("layouts/radicar_requisito.php");
    include("layouts/footer.php");