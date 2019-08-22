let botonProyecto = document.querySelector('.nuevo-proyecto');
let scrollProyectos = document.querySelector('.scroll-proyectos');

botonProyecto.setAttribute('id', 'botonProyecto');
scrollProyectos.setAttribute('id', 'scrollProyectos');


(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        let contenedorProyectos = document.querySelector('#scrollProyectos');
        let nuevoProyectos = document.querySelector('#botonProyecto')

        nuevoProyectos.addEventListener('click', nuevoProyecto);


        function nuevoProyecto(e) {
            e.preventDefault();
           

            //haremos que al precionar el clic, nos cree un elemento y lo incerte en el scroll 

            //solicitar el nombre del proyecto
            let nombreProyecto = document.createElement('a');
            nombreProyecto.innerHTML = '<input type="text" id="nuevoProyecto" placeholder="Proyecto">';
            nombreProyecto.classList.add('input-proyecto')
            scrollProyectos.append(nombreProyecto);


            let nuevoProyecto = document.querySelector('#nuevoProyecto');

            //de esta manera capturamos la tecla que es pulsada en el teclado. a diferenia de input que capturamos todo lo que escriba 
            nuevoProyecto.addEventListener('keypress', function(e) {
                let llave = e.key;

                if (llave === 'Enter') {
                    crearProyecto(nuevoProyecto.value)
                    nombreProyecto.remove()
                }
            

            })
            
            //funcion para insertar elemento y hacer llamado a ajaz 
            function crearProyecto(nombreProyecto) {

                //crear formData 

                let envioProyectoNew = new FormData();
                envioProyectoNew.append('newProyect', nombreProyecto);
                envioProyectoNew.append('accion', 'crearProyecto');

                //llamada a ajax 
                let xhr = new XMLHttpRequest();

                xhr.open('POST', 'modelos/funcionesindex.php', true)
        
                xhr.onload = function() {
                    if (xhr.status == 200) {
                        console.log(xhr.response);
                        
                    }else{
                        alert(`${xhr.status}: ${xhr.statusText}`); //en caso que no cargue el sitio, el error 
                    }
                }


                xhr.send(envioProyectoNew);

                //insertar elemento en el DOM
                let insertarProyecto = document.createElement('a');
                insertarProyecto.setAttribute('href', '#')
                insertarProyecto.innerHTML = `<p>${nombreProyecto}</p>`;
                scrollProyectos.prepend(insertarProyecto);


            }

        }


    })

})();