<?php 

/*la funcion basename retora el ultimo componente de la ruta o sea el nombre del archvo 
la variable $_SERVER retorna informacion de las rutas y cabeceras. el php_ self retorna el arhvo ejecutanzode actualmente
luego se usa str_replace para que solo nos retorne el nobre de la pagina sin la extencion 
*/
function obtenerPagActual(){
    $actual = basename($_SERVER['PHP_SELF']);
    $pagina = str_replace(".php", "", $actual);
    return $pagina;
}



?>