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


//retornar todos los valores de los proyectos 

function retornarNombrePro(){
    include 'bd-con.php';

    try {

        $funcionProyectos = $pdo->prepare( " SELECT idProyectos, nombreProyecto FROM proyectos ORDER BY fechaProyecto ASC " );
        $funcionProyectos->execute();

        return $funcionProyectos->fetchAll(PDO::FETCH_ASSOC);

    } catch (\Exception $th) {
        echo "Error!! {$th->getMessage()}";
        return false; 
    }

}

function mostrarNombreActual($var = null){
    include 'bd-con.php';

    try {

        $funcionProyectos = $pdo->prepare( " SELECT idProyectos, nombreProyecto FROM proyectos WHERE idProyectos = {$var} " );
        $funcionProyectos->execute();

        return $funcionProyectos->fetch(PDO::FETCH_ASSOC);

    } catch (\Exception $th) {
        echo "Error!! {$th->getMessage()}";
        return false; 
    }

}

?>