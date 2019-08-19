
<section class="fondo">

<div class="contenedor-total">

 

    <h1 class="centrar-texto">UpTask</h1>

    <div class="contenedor-formulario contenedor">

        <form id="formulario" class="formulario" >

            <div class="campo">
                <label for="usuario">Usuario</label>
                <input type="text" name="user" id="usuario" placeholder="Usuario">
            </div>
            <div class="campo">
                <label for="contrasena">Contraseña</label>
                <input type="password" name="password" id="contrasena" placeholder="Contraseña" >
            </div>

            <div class="contenedor-login">
            <?php 
                   include_once 'modelos/funciones.php'; 

                   $pagActual = obtenerPagActual(); //funcion para obtener la pagina actual y asi poder ingresar 

                   ?>
                    <input type="submit" value=" <?php echo ($pagActual == 'createaccount')? 'crear usuario' : 'entrar'  ?> "  id="submit" class="inicio-sesion btn btn-amarillo">
                    <input type="hidden" value="<?php echo $pagActual; ?>" id="accion" >
                <div class="btn-texto btn">
                    <a href="#" class="create-account" >crea una nueva cuenta</a>
                </div>
            </div>

        </form>

    </div>

</div>

</section>

