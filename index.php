<?php
include_once 'modelos/sesion.php';
include_once 'modelos/funciones.php';
include_once 'vistas/templates/header.php';
include_once 'vistas/templates/barra.php';

//optener id del proyecto
if (isset($_GET['idProyecto'])) {
    $idProyectoActual = filter_var($_GET['idProyecto'], FILTER_SANITIZE_NUMBER_INT);
}

?>



<section class="seccion-principal">
    <div class="proyectos ">

        <div class="contenedor">
            <div class="nuevo">
                <div class="btn btn-amarillo">
                    <a href="#" class="nuevo-proyecto">nuevo proyecto</a>
                </div>
            </div>

            <div class="muestra-proyectos centrar-texto">

                <h2 class="encabezado-proyectos">proyectos</h2>

                <div class="scroll-proyectos">

                    <?php
                    
                    $respuesta = retornarNombrePro();

                    foreach ($respuesta as $key => $value) { ?>

                    <a href="index.php?idProyecto=<?php echo $value['idProyectos']; ?>">
                        <p><?php echo $value['nombreProyecto']; ?></p>
                    </a>


                    <?php } ?>

                </div>

            </div>

        </div>
    </div>
    <div class="dashboard">

        <?php

        if ($idProyectoActual) {
            $obtenerNombreActual = mostrarNombreActual($idProyectoActual);
        
        ?>
        <h2 class="centrar-texto"><?php echo $obtenerNombreActual['nombreProyecto']?> </h2>
        
       

        <div class="agregar-tarea">
            <div class="campo">
                <label for="tarea">Tarea</label>
                <input type="text" name="nuevaTarea" id="nuevaTarea" placeholder="Nueva Tarea">
            </div>
            <div class="flex-agregar">
                <div class="btn btn-amarillo flex-agregar">
                    <a href="#" class="agregar" id="agregarTarea" >agregar</a>
                    <input type="hidden" id="idPro" value="<?php echo $idProyectoActual; ?>">
                    <input type="hidden" id="insertarTarea" value="insertarTarea">
                </div>
            </div>
        </div>

        <h2 class="centrar-texto">listado tareas</h2>

        <div class="listado-tareas">
            <h3>cambiar logo</h3>
            <div class="iconos">
                <a href=""><i class="fas fa-trash"></i></a> <a href=""><i class="fas fa-check-circle"></i></a>
            </div>
        </div>

        <?php  }else {
            echo "<p>Elige o crea un Proyecto</p>";
        } ?>

    </div>
</section>

<?php include_once 'vistas/templates/footer.php'  ?>