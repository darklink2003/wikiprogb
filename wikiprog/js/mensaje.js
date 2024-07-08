// mensaje.js

// Función para mostrar mensajes de alerta
function mostrarMensaje(mensaje, tipo = 'info') {
    const mensajeDiv = document.createElement('div');
    mensajeDiv.className = `alert alert-${tipo} mt-3`;
    mensajeDiv.textContent = mensaje;
    return mensajeDiv;
}

// Función para mostrar mensajes en un contenedor específico
function mostrarMensajeEnContenedor(contenedor, mensaje, tipo = 'info') {
    const mensajeDiv = mostrarMensaje(mensaje, tipo);
    contenedor.appendChild(mensajeDiv);

    // Remover el mensaje después de 5 segundos
    setTimeout(() => {
        mensajeDiv.remove();
    }, 5000);
}
