(function () {
    'use strict'

    document.addEventListener('DOMContentLoaded', function () {

        //leer los datos del formulario 


        let contenedorTotal = document.querySelector('.contenedor-total');


        if (document.querySelector('#formulario')) {
            //detectar cuando le den submit al formulario
            let formulario = document.querySelector('#formulario');
            formulario.addEventListener('submit', validarFormulario);

        }


        function validarFormulario(e) {
            e.preventDefault()

            let usuario = document.querySelector('#usuario').value,
                contrasena = document.querySelector('#contrasena').value,
                accion = document.querySelector('#accion').value



            if (usuario == '' || contrasena == '') {
                mostrarNotificacion(`<p>Rellena todos los campos</p>`, 'error');

            } else {

                let fechaCreacion = new Date();

                let crearFormData = new FormData()
                crearFormData.append('usuario', usuario);
                crearFormData.append('contrasena', contrasena);
                crearFormData.append('fecha', fechaCreacion)
                crearFormData.append('accion', accion);



                if (accion == 'createaccount') {
                    crearUsuario(crearFormData)
                }

                if (accion == 'login') {
                    verificarUsuario(crearFormData)
                }


            }

            function crearUsuario(params) {

                let xhr = new XMLHttpRequest();

                xhr.open('POST', 'modelos/funcionesdb.php', true)
                xhr.onload = function () {

                    if (xhr.status == 200) {

                        let respuestaJson = JSON.parse(xhr.response);

                        if (respuestaJson.estado == 'completado') {
                            mostrarNotificacion(`<p> ${respuestaJson.estado}</p>`, 'correcto');
                            document.querySelector('form').reset();
                        } else {
                            mostrarNotificacion(`${respuestaJson.contenido} error!!`, 'error')
                        }

                    } else {
                        alert(`${xhr.status}: ${xhr.statusText}`)
                    }

                }

                xhr.send(params)

            }

            function verificarUsuario(params) {

                let xhr = new XMLHttpRequest();

                xhr.open('POST', 'modelos/funcionesdb.php', true)
                xhr.onload = function () {

                    if (xhr.status == 200) {

                        let respuestaJson = JSON.parse(xhr.response);

                        if (respuestaJson.resultado === "Login correcto") {
                            mostrarNotificacion(`<p> ${respuestaJson.resultado} </p>`, 'correcto');
                            setTimeout(() =>{
                                window.location.href = "index.php"; //nos redirije a el index
                            },2000);
                           
                        } else {
                            mostrarNotificacion(`<p> ${respuestaJson.resultado} </p>`, 'error')
                        }



                    } else {
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