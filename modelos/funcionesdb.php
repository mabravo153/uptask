<?php 



if (isset($_POST['accion'])) {

   /* echo json_encode($_POST);*/

   
    if ($_POST['accion'] == 'create') {
        
        $usuario = filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
        $contrasenaSana = filter_var($_POST['contrasena'], FILTER_SANITIZE_STRING);
        $fechaCreacion = $_POST['fecha'];  

        $opciones = array(
            'cost' => 12
        ); //es un array asociatico que denota el costo del hash 

        $contrasena = password_hash($contrasenaSana,PASSWORD_BCRYPT, $opciones);//crear un hash de contraseña 
        

        try {
           include_once 'bd-con.php'; 

           $pdo->beginTransaction();
           $ingresarUsuario = $pdo->prepare(" INSERT INTO usuario (id, nombreUsuario, contresena, fechaCreaccion)
                                            VALUES (null, :nombreUsuario, :contrasena, fechaCreaccion) ");

            $ingresarUsuario->execute([
                ':nombreUsuario'=> $usuario,
                ':contrasena' => $contrasena,
                ':fechaCreaccion' =>$fechaCreacion
            ]);

            $pdo->commit();

            $respuesta = array(
                'estado'=> 'completado'
            );

        } catch (\Exception $th) {

            $pdo->rollBack();

            $respuesta = array(
                'error' => $th->getMessage()
            );

          
        }

        echo json_encode($respuesta); 

    }


}





?>