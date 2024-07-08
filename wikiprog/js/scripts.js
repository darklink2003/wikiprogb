/**
 * Este script se ejecuta cuando el DOM ha sido completamente cargado.
 * Carga la información del curso, las lecciones y los comentarios relacionados con un curso específico.
 */

document.addEventListener('DOMContentLoaded', function () {
    // Obtener parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const cursoId = urlParams.get('curso_id') || 1; // Si no se especifica curso_id, se utiliza 1 por defecto

    // Cargar información del curso
    cargarInfoCurso(cursoId);

    // Cargar lecciones del curso
    cargarLecciones(cursoId);

    // Cargar comentarios del curso
    cargarComentarios(cursoId);

    /**
     * Función para cargar la información del curso desde el servidor.
     * @param {number} cursoId - ID del curso para cargar la información específica.
     */
    function cargarInfoCurso(cursoId) {
        axios.get(`../model/get_courses.php`)
            .then(function (response) {
                const infoCursoContainer = document.getElementById('info-curso');
                const curso = response.data.find(curso => curso.curso_id == cursoId);

                if (curso) {
                    // Crear elementos HTML con la información del curso
                    const tituloCurso = document.createElement('h2');
                    tituloCurso.textContent = curso.titulo_curso;

                    const categoriaCurso = document.createElement('p');
                    categoriaCurso.textContent = `Categoría ID: ${curso.categoria_id}`;

                    const descripcionCurso = document.createElement('p');
                    descripcionCurso.textContent = curso.descripcion;

                    // Agregar elementos al contenedor de información del curso
                    infoCursoContainer.appendChild(tituloCurso);
                    infoCursoContainer.appendChild(categoriaCurso);
                    infoCursoContainer.appendChild(descripcionCurso);

                    // Agregar enlace para inscripción
                    const enlaceInscripcion = document.createElement('a');
                    enlaceInscripcion.textContent = 'Inscribirse';
                    enlaceInscripcion.href = `../controller/controlador.php?seccion=seccion8&curso_id=${curso.curso_id}`;
                    enlaceInscripcion.classList.add('btn', 'btn-primary', 'mt-3'); // Clases de Bootstrap para botón
                    infoCursoContainer.appendChild(enlaceInscripcion);
                } else {
                    console.error('No se encontró el curso con curso_id:', cursoId);
                }
            })
            .catch(function (error) {
                console.error('Error al cargar la información del curso:', error);
            });
    }

    /**
     * Función para cargar las lecciones de un curso desde el servidor.
     * @param {number} cursoId - ID del curso para cargar las lecciones asociadas.
     */
    function cargarLecciones(cursoId) {
        axios.get(`../model/get_lessons.php?curso_id=${cursoId}`)
            .then(function (response) {
                const leccionesContainer = document.getElementById('lecciones-container');
                leccionesContainer.innerHTML = ''; // Limpiar contenido anterior

                // Iterar sobre las lecciones y crear elementos HTML dinámicamente
                response.data.forEach(function (leccion) {
                    const leccionDiv = document.createElement('div');
                    leccionDiv.className = 'col mb-4';

                    const leccionContainer = document.createElement('div');
                    leccionContainer.className = 'leccion-container';

                    // Crear elementos con la información de cada lección
                    const titulo = document.createElement('h2');
                    titulo.textContent = leccion.titulo_leccion;

                    const contenido = document.createElement('p');
                    contenido.textContent = leccion.contenido;

                    // Agregar elementos al contenedor de la lección
                    leccionContainer.appendChild(titulo);
                    leccionContainer.appendChild(contenido);

                    // Si la lección tiene un archivo adjunto, agregar enlace de descarga
                    if (leccion.archivo_leccion) {
                        const enlaceArchivo = document.createElement('a');
                        enlaceArchivo.textContent = 'Descargar archivo';
                        enlaceArchivo.href = leccion.archivo_leccion;
                        enlaceArchivo.setAttribute('target', '_blank'); // Abrir en nueva pestaña
                        enlaceArchivo.style.display = 'block';
                        leccionContainer.appendChild(enlaceArchivo);
                    }

                    // Agregar contenedor de lección al contenedor principal
                    leccionDiv.appendChild(leccionContainer);
                    leccionesContainer.appendChild(leccionDiv);
                });
            })
            .catch(function (error) {
                console.error('Error al cargar las lecciones:', error);
            });
    }

    /**
     * Función para cargar los comentarios de un curso desde el servidor.
     * @param {number} cursoId - ID del curso para cargar los comentarios asociados.
     */
    function cargarComentarios(cursoId) {
        axios.get(`../model/get_comments.php?curso_id=${cursoId}`)
            .then(function (response) {
                const comentariosContainer = document.getElementById('comentarios-container');
                comentariosContainer.innerHTML = ''; // Limpiar contenido anterior

                // Iterar sobre los comentarios y crear elementos HTML dinámicamente
                response.data.forEach(function (comentario) {
                    const comentarioDiv = document.createElement('div');
                    comentarioDiv.className = 'comentario';

                    const nombreUsuario = document.createElement('h4');
                    nombreUsuario.textContent = comentario.nombre_usuario;

                    const contenidoComentario = document.createElement('p');
                    contenidoComentario.textContent = comentario.comentario;

                    const fechaComentario = document.createElement('small');
                    fechaComentario.textContent = `Publicado el: ${new Date(comentario.fecha_registro).toLocaleDateString()}`;

                    // Agregar elementos al contenedor del comentario
                    comentarioDiv.appendChild(nombreUsuario);
                    comentarioDiv.appendChild(contenidoComentario);
                    comentarioDiv.appendChild(fechaComentario);

                    // Agregar contenedor del comentario al contenedor principal
                    comentariosContainer.appendChild(comentarioDiv);
                });
            })
            .catch(function (error) {
                console.error('Error al cargar los comentarios:', error);
            });
    }
});
