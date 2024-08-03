document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const cursoId = parseInt(urlParams.get('curso_id')) || 1;

    cargarComentarios(cursoId);

    async function cargarComentarios(cursoId) {
        try {
            console.log('Cargando comentarios para cursoId:', cursoId);

            const response = await axios.get(`../model/get_comments.php?curso_id=${cursoId}`);
            console.log('Datos recibidos:', response.data);
            
            const comentariosContainer = document.getElementById('comentario-container');
            comentariosContainer.innerHTML = '';

            if (Array.isArray(response.data)) {
                response.data.forEach(comentario => {
                    const comentarioDiv = document.createElement('div');
                    comentarioDiv.className = 'col-lg-12 col-md-12 col-sm-12 mb-12';

                    const comentarioContainer = document.createElement('div');
                    comentarioContainer.className = 'comentario-container border rounded';

                    const usuario = document.createElement('h5');
                    usuario.textContent = comentario.nombre_usuario;

                    const fecha = document.createElement('p');
                    fecha.textContent = `Fecha: ${comentario.fecha_registro} (${comentario.tiempo_transcurrido})`;

                    const contenido = document.createElement('p');
                    contenido.textContent = comentario.comentario;

                    // Crear botón de eliminar
                    const eliminarBtn = document.createElement('button');
                    eliminarBtn.textContent = 'Eliminar';
                    eliminarBtn.className = 'btn btn-danger';
                    eliminarBtn.addEventListener('click', async () => {
                        const confirmed = confirm('¿Estás seguro de que deseas eliminar este comentario?');
                        if (confirmed) {
                            await eliminarComentario(comentario.comentario_id); // Asegúrate de usar el ID correcto
                            cargarComentarios(cursoId); // Recargar comentarios después de eliminar
                        }
                    });

                    // Agregar elementos al contenedor del comentario
                    comentarioContainer.appendChild(usuario);
                    comentarioContainer.appendChild(fecha);
                    comentarioContainer.appendChild(contenido);
                    comentarioContainer.appendChild(eliminarBtn);

                    // Agregar contenedor de comentario al contenedor principal
                    comentarioDiv.appendChild(comentarioContainer);
                    comentariosContainer.appendChild(comentarioDiv);
                });
            } else {
                console.log('La respuesta no contiene un array válido de comentarios.');
            }
        } catch (error) {
            console.error('Error al cargar los comentarios:', error);
            const comentariosContainer = document.getElementById('comentario-container');
            comentariosContainer.innerHTML = '<p>Error al cargar los comentarios. Inténtalo de nuevo más tarde.</p>';
        }
    }

    async function eliminarComentario(comentarioId) {
        try {
            const response = await axios.post(`../model/delete_comment.php`, { id: comentarioId });
            if (response.data.success) {
                console.log(`Comentario con ID ${comentarioId} eliminado exitosamente.`);
            } else {
                console.error(`Error al eliminar el comentario con ID ${comentarioId}:`, response.data.message);
            }
        } catch (error) {
            console.error('Error al eliminar el comentario:', error);
        }
    }
});
