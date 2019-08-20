<?php 

function usuarioAutenticado(){
    if (!revisarUsuario()) {
        header ('Location: login.php');
        exit();
    }
}

function revisarUsuario(){
   return isset ($_SESSION['nombreUsuario']);
}

session_start();
usuarioAutenticado();

?>