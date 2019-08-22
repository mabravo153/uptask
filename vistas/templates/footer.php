
<?php 
//con el fin de cargar solo los scripts necesarios 
 include_once 'modelos/funciones.php';

 $paginaActual = obtenerPagActual();

 if ($paginaActual === 'createaccount' || $paginaActual === 'login' ) {
     echo '<script src="vistas/js/main.js"></script>';
 }else{
    echo '<script src="vistas/js/scripts.js"></script>'; //visible solo para personas logueadas
 }


?>

</body>
</html>