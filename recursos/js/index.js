document.addEventListener("DOMContentLoaded", function () {
    const frmLogin = document.getElementById("frmLogin");
    const usuario = document.getElementById("usuario");
    const clave = document.getElementById("clave");

    frmLogin.addEventListener("submit", function (event) {
        let validacion = validarFormulario();

        if (validacion.valido) {
            return;
        }
        
        mostrarMensajeError(validacion.mensaje);

        event.preventDefault(); 
    });

    function validarFormulario() {
        let respuesta = {
            valido: false,
            mensaje: ""
        };

        if (usuario.value.trim() === "") {
            respuesta.mensaje = "El usuario no puede estar vacío";

            return respuesta;
        }

        if (clave.value.trim() === "") {
            respuesta.mensaje = "La clave no puede estar vacía";

            return respuesta;
        }

        respuesta.valido = true;

        return respuesta;
    }

    function mostrarMensajeError(mensaje) {
        swal("Error", mensaje, "error");
    }
});