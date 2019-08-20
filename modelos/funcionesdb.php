<?php



if (isset($_POST['accion'])) {

    //codigo para crear usuarios
    if ($_POST['accion'] == 'createaccount') {

        $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
        $contrasenaSana = filter_var($_POST['contrasena'], FILTER_SANITIZE_STRING);
        $fechaCreacion = $_POST['fecha'];

        //crear un hash de contraseña 
        $opciones = array(
            'cost' => 12
        ); //es un array asociatico que denota el costo del hash 

        $contrasena = password_hash($contrasenaSana, PASSWORD_BCRYPT, $opciones);


        try {
            include_once 'bd-con.php';

            $pdo->beginTransaction();
            $ingresarUsuario = $pdo->prepare(" INSERT INTO usuario (nombreUsuario, contrasena, fechaCreaccion)
                                            VALUES (:nombreUsuario, :contrasena, :fechaCreaccion) ");

            $ingresarUsuario->bindParam(':nombreUsuario', $usuario);
            $ingresarUsuario->bindParam(':contrasena', $contrasena);
            $ingresarUsuario->bindParam(':fechaCreaccion', $fechaCreacion);
            $ingresarUsuario->execute();


            $respuesta = array(
                'estado' => 'completado',
                'error' => $ingresarUsuario->errorInfo()
            );

            $pdo->commit();

            $ingresarUsuario = null;
            $pdo = null;
        } catch (\Exception $th) {

            $pdo->rollBack();

            $respuesta = array(
                'error' => 'ocurrio un error',
                'contenido' => $th->getMessage()
            );
        }

        echo json_encode($respuesta);
    }


    //codigo para loguear usuarios 
    if ($_POST['accion'] == 'login') {


        $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
        $contrasenaSana = filter_var($_POST['contrasena'], FILTER_SANITIZE_STRING);
        $fechaCreacion = $_POST['fecha'];

        include_once 'bd-con.php';

        try {

            $pdo->beginTransaction(); //iniciamos transaccion 

            //realizar consulta
            $busquedaUsuario = $pdo->prepare(" SELECT nombreUsuario, contrasena FROM usuario
                                            WHERE nombreUsuario=:nombreUsuario ");

            $busquedaUsuario->bindParam(':nombreUsuario', $usuario);
            $busquedaUsuario->execute();


            //loguear usuario 


            $pdo->commit();
        } catch (\Exception $th) {
            $pdo->rollBack();

            $resultadoLogin = array(
                'error' => $th->getMessage()
            );
        }


        echo json_encode($resultadoLogin);
    }
}
