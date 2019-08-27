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

        

        if ($insertarProyecto->rowCount() !== 0) {
            $respuestaProyeto = array(
                'respuesta' => 'guardado', 
                'id' => $pdo->lastInsertId(), //nos retorna el ultimo id insertado
                'nombre' => $nombreProyecto
            );
        }
       
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

if ($_POST['accion'] == 'insertarTarea') {
   
    $nombreTarea = filter_var($_POST['nuevaTarea'], FILTER_SANITIZE_STRING);
    $idOculto = (int) $_POST['idOculto'];

    include 'bd-con.php';

    try {
        
        $pdo->beginTransaction();

        $insertarTarea = $pdo->prepare( "INSERT INTO tareas (nombreTarea, estadoTarea, fk_idProyectos) 
                                         VALUES (:nombreTarea, :estadoTarea, :fk_idProyectos ) " );

        $insertarTarea->execute([
            ':nombreTarea' => $nombreTarea,
            ':estadoTarea' => '0',
            ':fk_idProyectos' => $idOculto
        ]);

        $respuestaTarea = array(
            'respuesta' => 'correcto',
            'idTarea' => $pdo->lastInsertId(),
            'nombreTarea' => $nombreTarea
        );

        $pdo->commit();

    } catch (\Exception $th) {
        
        $respuestaTarea = array(
            'respuesta' => $th->getMessage()
        );

    }

    echo json_encode($respuestaTarea);
}

if ($_POST['accion'] == 'actualizarEstado') {
   
    $idTareaModificada = $_POST['idTareaModificada'];

    include 'bd-con.php';

    try {
        
        $pdo->beginTransaction();
        $actualizarEstado = $pdo->prepare( " DELETE FROM tareas WHERE idTarea=:idTareaModificada ");
        $actualizarEstado->bindParam(':idTareaModificada', $idTareaModificada);
      
        $actualizarEstado->execute();

        $respuestaActualizar = array(
            'respuesta' => 'correcto'
        );

        $pdo->commit();
        $actualizarEstado = null; 
        $pdo = null;

    } catch (\Exception $th) {
        $respuestaActualizar = array(
            'error' => $th->getMessage()
        );
    }

    echo json_encode($respuestaActualizar);

}

}

?>