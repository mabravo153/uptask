<?php include_once 'vistas/templates/header.php' ?>

<div class="barra">
    <div class="contenedor-encabezado">
        <h1>Administrador de proyectos</h1>
    </div>
    <div class="alinear">
        <div class="btn cerrar-sesion">
            <a href="login.php" class="btn-cerrar">Cerrar Sesión</a>
        </div>
    </div>
</div>


<section class="seccion-principal">
    <div class="proyectos ">

        <div class="contenedor">
            <div class="nuevo">
                <div class="btn btn-amarillo">
                    <a href="#" class="nuevo-proyecto">nuevo proyecto +</a>
                </div>
            </div>

            <div class="muestra-proyectos centrar-texto">

                <h2 class="encabezado-proyectos">proyectos</h2>

                <div class="scroll-proyectos">
                    <a href="">
                        <p>Diseño pagina web</p>
                    </a>
                    <a href="">
                        <p>Diseño pagina web</p>
                    </a>
                </div>

            </div>

        </div>
    </div>
    <div class="dashboard">
        <h2 class="centrar-texto">Diseño pagina web</h2>

        <div class="agregar-tarea">
            <div class="campo">
                <label for="tarea">Tarea</label>
                <input type="text" name="nuevaTarea" id="nuevaTarea" placeholder="Nueva Tarea">
            </div>
        <div class="flex-agregar">
            <div class="btn btn-amarillo flex-agregar">
                <a href="#" class="agregar">agregar</a>
            </div>
            </div>
        </div>

        <h2 class="centrar-texto">listado tareas</h2>

        <div class="listado-tareas">
            <h3>cambiar logo</h3>
            <div class="iconos">
               <a href=""><i class="fas fa-trash"></i></a>   <a href=""><i class="fas fa-check-circle"></i></a>
            </div>
        </div>

    </div>
</section>

<?php include_once 'vistas/templates/footer.php'  ?>