<?php 

if (isset($_POST['accion'])) {
     //codigo para insertar proyecto 

 if ($_POST['accion'] == 'crearProyecto') {

    $nombreProyecto = filter_var($_POST['newProyect'], FILTER_SANITIZE_STRING); 

    include_once 'bd-con.php';

    try {

        $pdo->beginTransaction();
        $insertarProyecto = $pdo->prepare( "INSERT INTO proyectos (nombreProyecto) VALUES (:nombre)" );
        $insertarProyecto->bindParam(':nombre', $nombreProyecto);
        $insertarProyecto->execute();

        $pdo->commit();

    } catch (\Exception $th) {
        $pdo->rollBack();
        $respuestaProyeto = array(
            'respuesta' => $th->getMessage()
        );
    }
}


 

}

?>