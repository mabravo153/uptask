<?php

$usuario =  filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
$contrasenaSana = filter_var( $_POST['contrasena'], FILTER_SANITIZE_STRING);
$fechaCreacion = $_POST['fecha'];

if (isset($_POST['accion'])) {

    //codigo para crear usuarios
    if ($_POST['accion'] == 'createaccount') {

       

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
                'estado' => 'completado'
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

        include_once 'bd-con.php';

        try {

            $pdo->beginTransaction(); //iniciamos transaccion 

            //realizar consulta
            $busquedaUsuario = $pdo->prepare(" SELECT id,nombreUsuario, contrasena FROM usuario
                                            WHERE nombreUsuario=:nombreUsuario ");

            $busquedaUsuario->bindParam(':nombreUsuario', $usuario);
            $busquedaUsuario->execute();


            //loguear usuario 
            $busquedaUsuario->bindColumn(1, $idUsuario); //vincula una columna a una variable, esta es la funcion que  reemplaza bind_result
            $busquedaUsuario->bindColumn(2, $nombreUsuario);
            $busquedaUsuario->bindColumn(3, $contra);
            $busquedaUsuario->fetch(PDO::FETCH_ASSOC);
           
            //de eta manera verificamos si exisiste el usuario, en caso de existir, verfica el hash 
            if ($nombreUsuario) {  
                if (password_verify($contrasenaSana, $contra)) {//de esta manera verificamos si el password que ingresa el usuario es el que se encuentra en la base de datos 
                
                //iniciamos la sesion, es indispensable pasar los datos que queramos a la sesion

                session_start();
                $_SESSION['nombreUsuario'] = $usuario;
                $_SESSION['id'] = $idUsuario;
                $_SESSION['login'] = true;

                    $resultadoLogin = array(
                        'resultado' => 'Login correcto',
                        'nombre' => $nombreUsuario
                    );
                }else {
                    $resultadoLogin = array(
                        'resultado' => 'password incorrecto'
                    );
                }
            }else {
                $resultadoLogin = array(
                    'resultado' => 'No existe ese nombre de usuario'
                );
            }


            $pdo->commit();
            $busquedaUsuario = null;
            $pdo = null;
        } catch (\Exception $th) {
            $pdo->rollBack();

            $resultadoLogin = array(
                'error' => $th->getMessage()
            );
        }


        echo json_encode($resultadoLogin);
    }
}
