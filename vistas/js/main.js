(function () {
    'use strict'

    document.addEventListener('DOMContentLoaded', function() {
        
        //leer los datos del formulario 

        let formulario = document.querySelector('#formulario');
        let contenedorTotal = document.querySelector('.contenedor-total') ;


            //detectar cuando le den submit al formulario
            formulario.addEventListener('submit',function(e) {
                e.preventDefault()

            let usuario = document.querySelector('#usuario').value, 
                contraseña = document.querySelector('#contrasena').value,
                submit = document.querySelector('#submit').value


                
                if (usuario == '' || contraseña == '') {
                    console.log('funciona');
                    
                }


            })

            //mostrar notificacion 

            function mostrarNotificacion(texto, clase) {
                
                let notificacion = document.createElement('div');

                setTimeout(() => {
                    



                }, 1000);

            }







    })
})();