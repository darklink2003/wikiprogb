document.addEventListener('DOMContentLoaded', function () {
    // Obtener parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const cursoId = urlParams.get('curso_id') || 1; // Si no se especifica curso_id, se utiliza 1 por defecto

    // Cargar comentarios del curso al cargar la página
    cargarComentarios(cursoId);

    /**
     * Función para cargar los comentarios de un curso desde el servidor.
     * @param {number} cursoId - ID del curso para cargar los comentarios asociados.
     */
    function cargarComentarios(cursoId) {
        // Realizar solicitud GET usando Axios
        axios.get(`../model/get_comments.php?curso_id=${cursoId}`)
            .then(function (response) {
                const comentariosContainer = document.getElementById('comentario-container');
                comentariosContainer.innerHTML = ''; // Limpiar contenido anterior

                // Iterar sobre los comentarios recibidos
                response.data.forEach(function (comentario) {
                    // Crear elementos HTML para cada comentario
                    const comentarioDiv = document.createElement('div');
                    comentarioDiv.className = 'col mb-4';

                    const comentarioContainer = document.createElement('div');
                    comentarioContainer.className = 'comentario-container';

                    // Elementos para mostrar información del comentario
                    const usuario = document.createElement('h5');
                    usuario.textContent = `Usuario: ${comentario.nombre_usuario}`;

                    const fecha = document.createElement('p');
                    fecha.textContent = `Fecha: ${comentario.fecha_registro}`;

                    const contenido = document.createElement('p');
                    contenido.textContent = comentario.comentario;

                    // Agregar elementos al contenedor del comentario
                    comentarioContainer.appendChild(usuario);
                    comentarioContainer.appendChild(fecha);
                    comentarioContainer.appendChild(contenido);

                    // Agregar contenedor de comentario al contenedor principal
                    comentarioDiv.appendChild(comentarioContainer);
                    comentariosContainer.appendChild(comentarioDiv);
                });
            })
            .catch(function (error) {
                console.error('Error al cargar los comentarios:', error);
            });
    }
});
