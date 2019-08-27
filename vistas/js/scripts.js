let botonProyecto = document.querySelector('.nuevo-proyecto');
let scrollProyectos = document.querySelector('.scroll-proyectos');

botonProyecto.setAttribute('id', 'botonProyecto');
scrollProyectos.setAttribute('id', 'scrollProyectos');


(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {


        /* FUNCIONES GENERALES*/

        //funcion para crear elementos 
        function createElement(element, atributos, contenido) {
            let elementNuevo = document.createElement(element);

            if (contenido !== undefined) {

                contenido.forEach(element => {
                    if (element.nodeType) {

                        if (element.nodeType === 1) {
                            elementNuevo.append(element);
                        }

                    } else {
                        elementNuevo.innerHTML += element
                    }
                });

            }

            insertarAtributos(elementNuevo, atributos)

            return elementNuevo
        }


        //insertar atributos 
        function insertarAtributos(elemento, obj) {
            let atributos = new Map(Object.entries(obj));

            atributos.forEach((value, key, map) => {

                if (atributos.has(key)) {

                    elemento.setAttribute(`${key}`, `${value}`);

                }

            });

        }

        function crearVentanaModal(params) {

            let contenidoMod = createElement('div', { id: 'idcontenidoMod', class: 'contenido-modal' }, [params])
            let contenedorMod = createElement('div', { id: 'idcontenedorMod', class: 'contenedor-mod' }, [contenidoMod]);//creamos los contenedores de la ventana 

            document.body.append(contenedorMod); //la a gregamos al documento

            function removerModal() {
                contenedorMod.remove();
            }

            contenedorMod.addEventListener('click', (e) => {

                if (e.target === contenedorMod) {//en caso que sea en el evento targen, removemos la ventana 

                    removerModal();
                }

            })

        }




        /*MANUPULAR EL DOM */


        //crear proyecto nuevo 
        let nuevoProyectos = document.querySelector('#botonProyecto')

        nuevoProyectos.addEventListener('click', nuevoProyecto);


        function nuevoProyecto(e) {
            e.preventDefault();


            //haremos que al precionar el clic, crearemsos una ventana modal 
            //ejecutar funcion crear ventana modal 

            let inputmodal = createElement('input', { id: 'inputModal', class: 'input-modal', type: 'text', placeholder: "Nombre Proyecto" })
            crearVentanaModal(inputmodal);

            //capturar la informacion de la ventada y luego cerrarla 

            let inputModal = document.querySelector('#inputModal')

            inputModal.addEventListener('keypress', (e) => {

                let teclaPresionada = e.key;

                if (teclaPresionada == 'Enter') {

                    crearProyecto(inputModal.value);
                    document.querySelector('#idcontenedorMod').remove();
                }



            })

            //funcion para insertar elemento y hacer llamado a ajax 
            function crearProyecto(nombreProyecto) {

                //crear formData 

                let fechaProyecto = new Date();

                let envioProyectoNew = new FormData();
                envioProyectoNew.append('newProyect', nombreProyecto);
                envioProyectoNew.append('fechaProyecto', fechaProyecto);
                envioProyectoNew.append('accion', 'crearProyecto');

                //llamada a ajax 
                let xhr = new XMLHttpRequest();

                xhr.open('POST', 'modelos/funcionesindex.php', true)

                xhr.onload = function () {
                    if (xhr.status == 200) {
                        let json = JSON.parse(xhr.response);

                        if (json.respuesta == 'guardado') {

                            crearVentanaModal(`<p> Proyecto ${json.respuesta}`)

                            //insertar elemento en el DOM

                            let contenedorProyectos = document.querySelector('#scrollProyectos');
                            let parrafoProyecto = createElement('a', { href: `index.php?idProyecto=${json.id}`, id: `${json.nombre}` }, [`<p> ${inputModal.value} </p>`]);
                            contenedorProyectos.prepend(parrafoProyecto);

                            setTimeout(() => {
                                window.location.href = `index.php?idProyecto=${json.id}`;
                            }, 1000);



                        } else {
                            crearVentanaModal(`<p> ${json.respuesta}`)
                        }

                    } else {
                        alert(`${xhr.status}: ${xhr.statusText}`); //en caso que no cargue el sitio, el error 
                    }
                }


                xhr.send(envioProyectoNew);

            }

        }



        //crear tarea 

        if (document.querySelector('#agregarTarea')) {
            let agregarTarea = document.querySelector('#agregarTarea');

            agregarTarea.addEventListener('click', (e) => {
                e.preventDefault()

                let inputNuevaTarea = document.querySelector('#nuevaTarea').value;
                let idOculto = document.querySelector('#idPro').value;
                let insertarTarea = document.querySelector('#insertarTarea').value



                if (inputNuevaTarea == "" || idOculto == "") {

                    crearVentanaModal(`<p>Inserta una Tarea </p>`);

                } else {

                    let nuevaTarea = new FormData()
                    nuevaTarea.append('nuevaTarea', inputNuevaTarea);
                    nuevaTarea.append('idOculto', idOculto);
                    nuevaTarea.append('accion', insertarTarea)

                    if (insertarTarea == 'insertarTarea') {
                        insertarTareaF(nuevaTarea);
                    }

                }

                async function insertarTareaF(params) {

                    let envioTarea = await fetch('modelos/funcionesindex.php', { method: 'POST', body: params });

                    if (envioTarea.ok) {
                        let respuestaJson = await envioTarea.json();

                        if (respuestaJson.respuesta == 'correcto') {

                            let listaTareas = document.querySelector('.listado-tareas')

                            crearVentanaModal(`<p>La tarea: ${respuestaJson.nombreTarea} se añadio correctamente</p>`)

                            let iconos = createElement('div', { class: 'iconos' }, [`<a href="#"><i class="fas fa-trash"></i></a> <a href="#"><i class="fas fa-check-circle"></i></a>`])
                            let contenedorTareas = createElement('div', { class: 'contenedor-tareas', id: `${respuestaJson.idTarea}` }, [`<h3>${respuestaJson.nombreTarea}</h3>`, iconos])

                            listaTareas.append(contenedorTareas)

                        } else {
                            crearVentanaModal(`<p>Ocurrio un error al agregar ${respuestaJson.nombreTarea}</p>`)
                        }



                    } else {
                        alert(`${envioTarea.status}: ${envioTarea.statusText}`)
                    }

                }

            });//crear tarea 

        }


        //asignar el progreso  y eliminar las tareas 

        if (document.querySelector('.listado-tareas')) {

            let listadoTarea = document.querySelector('.listado-tareas')

            listadoTarea.addEventListener('click', (e) => {
                e.preventDefault();

                //completar tarea y eliminarla del DOM
                if (e.target.classList.contains('fa-check-circle')) {

                    actualizarEstado(e.target)

                }

                async function actualizarEstado(elementoTarget) {
                    let elementoContenedor = elementoTarget.parentElement.parentElement.parentElement
                    let idElementoContenedor = elementoContenedor.getAttribute('id');

                    let actualizarEstado = new FormData()
                    actualizarEstado.append('idTareaModificada', idElementoContenedor)
                    actualizarEstado.append('accion', 'actualizarEstado')


                    let updateState = await fetch('modelos/funcionesindex.php', { method: 'POST', body: actualizarEstado })

                    if (updateState.ok) {
                        let respuestaState = await updateState.json()
                        if (respuestaState.respuesta == 'correcto') {
                            elementoContenedor.remove();
                        }
                    }
                }

            })
        }



        //funcion para crear barra 
        let contenedioBarra = createElement('div', { id: 'contenidoBarra', class: 'contenido-barra' })

        let contenedorBarra = createElement('div', { id: 'contenedorBarra', class: 'contenedor-barra' }, [contenedioBarra])
        window.addEventListener('scroll', () => {

            let totalResta = document.body.scrollHeight - document.documentElement.clientHeight

            let scrolltop = window.pageYOffset

            let total = Math.round((scrolltop / totalResta) * 100)

            
            document.body.prepend(contenedorBarra)

            document.querySelector('#contenidoBarra').style.width = `${total}%`

        })






    })
})();