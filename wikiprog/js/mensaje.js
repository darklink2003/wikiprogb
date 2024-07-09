// mensaje.js

function mostrarMensaje(tipo) {
    switch(tipo) {
        case 'exito':
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Tu trabajo se ha guardado",
                showConfirmButton: false,
                timer: 1500
            });
            break;
        case 'olvido':
            Swal.fire({
                title: "¿Olvidaste tu contraseña?",
                text: "Recupera tu contraseña a través del enlace proporcionado.",
                icon: "question"
            });
            break;
        case 'error':
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Algo salió mal. Inténtalo de nuevo.",
                footer: '<a href="#">¿Por qué tengo este problema?</a>'
            });
            break;
        default:
            Swal.fire({
                icon: "info",
                title: "Información",
                text: "Acción no especificada."
            });
            break;
    }
}

function mostrarMensajeEnContenedor(contenedor, mensaje, tipo) {
    const alertType = tipo === 'danger' ? 'alert-danger' : 'alert-success';
    contenedor.innerHTML = `<div class="alert ${alertType}" role="alert">${mensaje}</div>`;
}
