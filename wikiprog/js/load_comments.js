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
                    usuario.textContent = `${comentario.nombre_usuario}`;

                    const fecha = document.createElement('p');
                    fecha.textContent = `Fecha: ${comentario.fecha_registro} (${comentario.tiempo_transcurrido})`;

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
            } else {
                console.log('La respuesta no contiene un array válido de comentarios.');
            }
        } catch (error) {
            console.error('Error al cargar los comentarios:', error);
            const comentariosContainer = document.getElementById('comentario-container');
            comentariosContainer.innerHTML = '<p>Error al cargar los comentarios. Inténtalo de nuevo más tarde.</p>';
        }
    }

    // Eliminar la función manejarInteraccion ya que no se necesita
});
