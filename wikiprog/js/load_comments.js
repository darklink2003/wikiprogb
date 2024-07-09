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
                    comentarioDiv.className = 'col-lg-6 col-md-6 col-sm-12 mb-4'; // Ajusta las columnas según tus necesidades
    
                    const comentarioContainer = document.createElement('div');
                    comentarioContainer.className = 'comentario-container p-3 border rounded'; // Estilos de borde y redondez
    
                    // Elementos para mostrar información del comentario
                    const usuario = document.createElement('h5');
                    usuario.textContent = `Usuario: ${comentario.nombre_usuario}`;
    
                    const fecha = document.createElement('p');
                    fecha.textContent = `Fecha: ${comentario.fecha_registro}`;
    
                    const contenido = document.createElement('p');
                    contenido.textContent = comentario.comentario;
    
                    // Mostrar número de likes
                    const likes = document.createElement('p');
                    likes.textContent = `Likes: ${comentario.megustac}`;
    
                    // Mostrar número de dislikes
                    const dislikes = document.createElement('p');
                    dislikes.textContent = `Dislikes: ${comentario.dislike}`;
    
                    // Botón Like con imagen (Bootstrap)
                    const botonLike = document.createElement('button');
                    botonLike.className = 'btn btn-primary boton-like';
                    botonLike.innerHTML = '<i class="fas fa-thumbs-up"></i> Like';
                    botonLike.style.marginRight = '5px'; // Espacio entre botones
                    botonLike.addEventListener('click', function() {
                        // Aquí puedes agregar la lógica para dar "like" al comentario
                        alert('Dar like al comentario: ' + comentario.comentario_id);
                    });
    
                    // Botón Dislike con imagen (Bootstrap)
                    const botonDislike = document.createElement('button');
                    botonDislike.className = 'btn btn-danger boton-dislike';
                    botonDislike.innerHTML = '<i class="fas fa-thumbs-down"></i> Dislike';
                    botonDislike.style.marginRight = '5px'; // Espacio entre botones
                    botonDislike.addEventListener('click', function() {
                        // Aquí puedes agregar la lógica para dar "dislike" al comentario
                        alert('Dar dislike al comentario: ' + comentario.comentario_id);
                    });
    
                    // Botón Editar con texto (Bootstrap)
                    const botonEditar = document.createElement('button');
                    botonEditar.className = 'btn btn-warning boton-editar';
                    botonEditar.textContent = 'Editar';
                    botonEditar.style.marginRight = '5px'; // Espacio entre botones
                    botonEditar.addEventListener('click', function() {
                        // Aquí puedes agregar la lógica para editar el comentario
                        alert('Editar comentario: ' + comentario.comentario_id);
                    });
    
                    // Botón Eliminar con texto (Bootstrap)
                    const botonEliminar = document.createElement('button');
                    botonEliminar.className = 'btn btn-danger boton-eliminar';
                    botonEliminar.textContent = 'Eliminar';
                    botonEliminar.addEventListener('click', function() {
                        // Aquí puedes agregar la lógica para eliminar el comentario
                        if (confirm('¿Estás seguro de eliminar este comentario?')) {
                            // Lógica para eliminar el comentario (ejemplo)
                            console.log('Eliminar comentario: ' + comentario.comentario_id);
                        }
                    });
    
                    // Agregar elementos al contenedor del comentario
                    comentarioContainer.appendChild(usuario);
                    comentarioContainer.appendChild(fecha);
                    comentarioContainer.appendChild(contenido);
                    comentarioContainer.appendChild(likes); // Mostrar likes
                    comentarioContainer.appendChild(dislikes); // Mostrar dislikes
                    comentarioContainer.appendChild(botonLike);
                    comentarioContainer.appendChild(botonDislike);
                    comentarioContainer.appendChild(botonEditar);
                    comentarioContainer.appendChild(botonEliminar);
    
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
