document.addEventListener('DOMContentLoaded', () => {
    // Obtener parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const cursoId = parseInt(urlParams.get('curso_id')) || 1; // Si no se especifica curso_id, se utiliza 1 por defecto

    // Cargar comentarios del curso al cargar la página
    cargarComentarios(cursoId);

    /**
     * Función para cargar los comentarios de un curso desde el servidor.
     * @param {number} cursoId - ID del curso para cargar los comentarios asociados.
     */
    async function cargarComentarios(cursoId) {
        try {
            console.log('Cargando comentarios para cursoId:', cursoId); // Verificar la llamada de carga de comentarios

            // Realizar solicitud GET usando Axios
            const response = await axios.get(`../model/get_comments.php?curso_id=${cursoId}`);
            console.log('Datos recibidos:', response.data); // Verificar los datos recibidos
            
            const comentariosContainer = document.getElementById('comentario-container');
            comentariosContainer.innerHTML = ''; // Limpiar contenido anterior

            // Verificar si hay datos en response.data
            if (Array.isArray(response.data)) {
                // Iterar sobre los comentarios recibidos
                response.data.forEach(comentario => {
                    // Crear elementos HTML para cada comentario
                    const comentarioDiv = document.createElement('div');
                    comentarioDiv.className = 'col-lg-12 col-md-12 col-sm-12 mb-12'; // Ajusta las columnas según tus necesidades

                    const comentarioContainer = document.createElement('div');
                    comentarioContainer.className = 'comentario-container border rounded'; // Estilos de borde y redondez

                    // Elementos para mostrar información del comentario
                    const usuario = document.createElement('h5');
                    usuario.textContent = `Usuario: ${comentario.nombre_usuario}`;

                    const fecha = document.createElement('p');
                    fecha.textContent = `Fecha: ${comentario.fecha_registro}`;

                    const contenido = document.createElement('p');
                    contenido.textContent = comentario.comentario;

                    // Elementos para mostrar conteo de likes y dislikes
                    const likes = document.createElement('p');
                    likes.textContent = `Likes: ${comentario.count_likes}`;

                    const dislikes = document.createElement('p');
                    dislikes.textContent = `Dislikes: ${comentario.count_dislikes}`;

                    // Botón de like
                    const likeButton = document.createElement('button');
                    likeButton.textContent = 'Like';
                    likeButton.className = 'like-button';
                    likeButton.addEventListener('click', () => {
                        manejarInteraccion(comentario.comentario_id, 'like', () => {
                            comentario.count_likes++;
                            likes.textContent = `Likes: ${comentario.count_likes}`;
                        });
                    });

                    // Botón de dislike
                    const dislikeButton = document.createElement('button');
                    dislikeButton.textContent = 'Dislike';
                    dislikeButton.className = 'dislike-button';
                    dislikeButton.addEventListener('click', () => {
                        manejarInteraccion(comentario.comentario_id, 'dislike', () => {
                            comentario.count_dislikes++;
                            dislikes.textContent = `Dislikes: ${comentario.count_dislikes}`;
                        });
                    });

                    // Agregar elementos al contenedor del comentario
                    comentarioContainer.appendChild(usuario);
                    comentarioContainer.appendChild(fecha);
                    comentarioContainer.appendChild(contenido);
                    comentarioContainer.appendChild(likes);
                    comentarioContainer.appendChild(dislikes);
                    comentarioContainer.appendChild(likeButton);
                    comentarioContainer.appendChild(dislikeButton);

                    // Agregar contenedor de comentario al contenedor principal
                    comentarioDiv.appendChild(comentarioContainer);
                    comentariosContainer.appendChild(comentarioDiv);
                });
            } else {
                console.log('La respuesta no contiene un array válido de comentarios.');
            }
        } catch (error) {
            console.error('Error al cargar los comentarios:', error);
            // Mostrar mensaje de error en la UI
            const comentariosContainer = document.getElementById('comentario-container');
            comentariosContainer.innerHTML = '<p>Error al cargar los comentarios. Inténtalo de nuevo más tarde.</p>';
        }
    }

    /**
     * Función para enviar una interacción de like o dislike al servidor.
     * @param {number} comentarioId - ID del comentario a interactuar.
     * @param {string} accion - Acción a realizar ('like' o 'dislike').
     * @param {Function} callback - Función a ejecutar después de procesar la interacción.
     */
    async function manejarInteraccion(comentarioId, accion, callback) {
        try {
            // Deshabilitar botones mientras se procesa la solicitud
            const likeButton = document.querySelector(`button[data-comentario-id="${comentarioId}"].like-button`);
            const dislikeButton = document.querySelector(`button[data-comentario-id="${comentarioId}"].dislike-button`);
            likeButton.disabled = true;
            dislikeButton.disabled = true;

            // Realizar solicitud POST usando Axios
            await axios.post('../model/manejar_like_dislike.php', {
                usuario_id: 1, // Ajusta esto según tu lógica para obtener el usuario_id
                comentario_id: comentarioId,
                accion: accion
            });

            // Ejecutar el callback proporcionado para actualizar el frontend
            callback();
            console.log(`Interacción de ${accion} registrada correctamente.`);
        } catch (error) {
            console.error(`Error al procesar ${accion}:`, error);
            // Opcional: mostrar mensaje de error en la UI
        } finally {
            // Habilitar botones después de procesar la solicitud
            const likeButton = document.querySelector(`button[data-comentario-id="${comentarioId}"].like-button`);
            const dislikeButton = document.querySelector(`button[data-comentario-id="${comentarioId}"].dislike-button`);
            likeButton.disabled = false;
            dislikeButton.disabled = false;
        }
    }
});
