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

                            setTimeout(() =>{
                                window.location.href = `index.php?idProyecto=${json.id}`;
                            },1000);



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



    })
})();