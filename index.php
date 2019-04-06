<?php 
    session_start();
    if(!isset($_SESSION['IDEMPLEADO'])) {
       header("Location:views/login/login.php");
    }else {
        header("Location:views/requisito/crear.php");
    }
        