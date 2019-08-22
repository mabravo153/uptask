<?php

session_start(); //con esto incluimos todos los parametros que esten en la sesion, agregados en el momento de verificar el usuario
if (isset($_GET['cerrarSesion'])) {
    $_SESSION = array(); //de esta forma borramos las variables de la sesion 
};

include_once 'vistas/templates/header.php' ?>

<?php include_once 'vistas/templates/formulario.php'  ?>

<?php include_once 'vistas/templates/footer.php'  ?>