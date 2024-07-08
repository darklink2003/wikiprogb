// Función para mostrar el modal de confirmación
function confirmarEliminarCuenta() {
    document.getElementById('myModal').style.display = 'block';
}

// Función para cerrar el modal
function cerrarModal() {
    document.getElementById('myModal').style.display = 'none';
}

// Función para eliminar la cuenta
function eliminarCuenta() {
    // Aquí puedes añadir una llamada AJAX para eliminar la cuenta del usuario en el servidor
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "controlador.php?accion=eliminarCuenta", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Suponiendo que el servidor responde con éxito
            alert("Cuenta eliminada exitosamente.");
            window.location.href = "controlador.php?seccion=seccion2";
        }
    };
    xhr.send();
}

// Cerrar el modal si el usuario hace clic fuera de él
window.onclick = function(event) {
    var modal = document.getElementById('myModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}
