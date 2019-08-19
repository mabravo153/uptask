(function () {
    'use strict'

    document.addEventListener('DOMContentLoaded', function () {

        //leer los datos del formulario 

        let formulario = document.querySelector('#formulario');
        let contenedorTotal = document.querySelector('.contenedor-total');


        //detectar cuando le den submit al formulario
        formulario.addEventListener('submit', validarFormulario)
        



        function validarFormulario (e) {
            e.preventDefault()

            let usuario = document.querySelector('#usuario').value,
                contrasena = document.querySelector('#contrasena').value,
                accion = document.querySelector('#accion').value



            if (usuario == '' || contrasena == '') {
                mostrarNotificacion(`<p>Rellena todos los campos</p>`, 'error');

            } else {

                let creacion = new Date();

                let crearFormData = new FormData()
                crearFormData.append('usuario', usuario);
                crearFormData.append('contrasena', contrasena);
                crearFormData.append('fecha', creacion)
                crearFormData.append('accion', accion);



                if (accion == 'createaccount') {
                    crearUsuario(crearFormData)
                }

                if(accion == 'login'){
                 
                
                }


            }

             function crearUsuario(params) {
                
                let xhr = new XMLHttpRequest();

                xhr.open('POST', 'modelos/funcionesdb.php',true)
                xhr.onload = function () {
                    
                    if (xhr.status == 200) {
                       
                       let respuestaJson = JSON.parse(xhr.response);

                       console.log(respuestaJson);
                       
                        
                    }else{
                        alert(`${xhr.status}: ${xhr.statusText}`)
                    }

                }

                xhr.send(params)

            }



        }

        //mostrar notificacion
        function mostrarNotificacion(texto, clase) {

            let notificacion = document.createElement('div');
            notificacion.classList.add('notificacion');
            contenedorTotal.append(notificacion);

            setTimeout(() => {
                notificacion.classList.add(clase);
                notificacion.innerHTML = texto
                notificacion.classList.add('visible')

                setTimeout(() => {
                    notificacion.classList.remove('visible');
                    notificacion.remove();
                }, 3000);
            }, 100);

        }







    })
})();