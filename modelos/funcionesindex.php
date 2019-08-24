<?php 

if (isset($_POST['accion'])) {
     //codigo para insertar proyecto 

 if ($_POST['accion'] == 'crearProyecto') {

    $nombreProyecto = filter_var($_POST['newProyect'], FILTER_SANITIZE_STRING); 
    $fechaProyecto = $_POST['fechaProyecto'];
    include_once 'bd-con.php';

    try {

        $pdo->beginTransaction();

        $insertarProyecto = $pdo->prepare( "INSERT INTO proyectos (nombreProyecto, fechaProyecto) VALUES (:nombre, :fechaProyecto)" );
        $insertarProyecto->bindParam(':nombre', $nombreProyecto);
        $insertarProyecto->bindParam(':fechaProyecto', $fechaProyecto);
        $insertarProyecto->execute();

        

        $respuestaProyeto = array(
            'respuesta' => 'guardado'
        );

        $pdo->commit(); 

        $insertarProyecto = null;
        $pdo = null; 

    } catch (\Exception $th) {
        $pdo->rollBack();
        $respuestaProyeto = array(
            'respuesta' => $th->getMessage()
        );
    }

    echo json_encode($respuestaProyeto);

}

 

}

?>