/**
 * funciiones.js
 * Evento que se dispara cuando el DOM se ha cargado por completo.
 * Carga los cursos iniciales y configura el manejador de eventos para la búsqueda de cursos.
 */
document.addEventListener('DOMContentLoaded', function () {
    cargarCursos(); // Cargar cursos al cargar la página

    const formBusqueda = document.getElementById('form-busqueda');

    formBusqueda.addEventListener('submit', function (event) {
        event.preventDefault(); // Evitar el envío por defecto del formulario

        const formData = new FormData(formBusqueda);
        const searchParams = new URLSearchParams(formData).toString();

        fetch(`../model/buscar.php?${searchParams}`)
            .then(response => response.json())
            .then(data => {
                renderCursos(data);
            })
            .catch(error => {
                console.error('Error fetching courses:', error);
            });
    });
});

/**
 * Carga los cursos iniciales y los renderiza en la página.
 */
function cargarCursos() {
    mostrarIndicadorCarga(true);
    fetch('../model/get_courses.php')
        .then(response => response.json())
        .then(data => {
            mostrarIndicadorCarga(false);
            renderCursos(data);
        })
        .catch(error => {
            mostrarIndicadorCarga(false);
            mostrarMensajeError('Error fetching courses:', error);
        });
}

/**
 * Muestra u oculta un indicador de carga.
 * @param {boolean} mostrar - Si es verdadero, muestra el indicador; de lo contrario, lo oculta.
 */
function mostrarIndicadorCarga(mostrar) {
    const indicadorCarga = document.getElementById('indicador-carga');
    indicadorCarga.style.display = mostrar ? 'block' : 'none';
}

/**
 * Muestra un mensaje de error en la página.
 * @param {string} mensaje - El mensaje de error a mostrar.
 * @param {Error} error - El objeto de error que se produjo.
 */
function mostrarMensajeError(mensaje, error) {
    const errorContainer = document.getElementById('error-container');
    errorContainer.textContent = mensaje;
    console.error(error);
}

/**
 * Renderiza una lista de cursos en la página.
 * @param {Array} data - Una lista de objetos de cursos.
 */
function renderCursos(data) {
    const cursosContainer = document.getElementById('cursos-container');
    const cursoTemplate = document.getElementById('curso-template').innerHTML;

    cursosContainer.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos cursos

    data.forEach(curso => {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = cursoTemplate.replace(/{curso_id}/g, curso.curso_id);

        const cursoDiv = tempDiv.firstElementChild;

        cursoDiv.querySelector('.titulo-curso').textContent = curso.titulo_curso;
        cursoDiv.querySelector('.descripcion-curso').textContent = curso.descripcion;
        cursoDiv.querySelector('.ver-lecciones-link').href = `../controller/controlador.php?seccion=seccion7&curso_id=${curso.curso_id}`;

        // Obtener likes y dislikes
        obtenerInteracciones(curso.curso_id, cursoDiv);

        cursosContainer.appendChild(cursoDiv);
    });
}

/**
 * Obtiene y muestra las interacciones (likes y dislikes) de un curso.
 * @param {number} cursoId - El ID del curso.
 * @param {HTMLElement} cursoDiv - El elemento DOM donde se mostrarán las interacciones.
 */
function obtenerInteracciones(cursoId, cursoDiv) {
    fetch(`../model/get_interacion.php?curso_id=${cursoId}`)
        .then(response => response.json())
        .then(data => {
            cursoDiv.querySelector('.like-count').textContent = `aprovado: ${data.like}`;
            cursoDiv.querySelector('.dislike-count').textContent = `desaprovado: ${data.dislike}`;
        })
        .catch(error => console.error('Error fetching interactions:', error));
}


/**
 * Carga y muestra las lecciones de un curso específico.
 * @param {number} cursoId - El ID del curso.
 */
function cargarLecciones(cursoId) {
    fetch(`../model/get_lessons.php?curso_id=${cursoId}`)
        .then(response => response.json())
        .then(data => {
            const leccionesContainer = document.getElementById('lecciones-container');
            leccionesContainer.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevas lecciones

            data.forEach(leccion => {
                const leccionDiv = document.createElement('div');
                leccionDiv.className = 'leccion';

                const titulo = document.createElement('h2');
                titulo.textContent = leccion.titulo_leccion;

                const contenido = document.createElement('p');
                contenido.textContent = leccion.contenido;

                const fecha = document.createElement('p');
                fecha.textContent = `Fecha: ${leccion.fecha_registro}`;

                leccionDiv.appendChild(titulo);
                leccionDiv.appendChild(contenido);
                leccionDiv.appendChild(fecha);
                leccionesContainer.appendChild(leccionDiv);
            });
        })
        .catch(error => {
            console.error('Error fetching lessons:', error);
        });
}

/**
 * Agrega una nueva lección al formulario de lecciones.
 */
function agregarLeccion() {
    const leccionesDiv = document.getElementById('lecciones');

    // Crear el HTML de la nueva lección
    const nuevaLeccionHTML = `
        <div class="col-md-12 mt-3">
            <div class="bg-dark p-3 rounded">
                <div class="form-group mb-3">
                    <label for="titulo_leccion" class="form-label">Título de la lección</label>
                    <input type="text" class="form-control" name="titulo_leccion[]" placeholder="Título de la lección" required>
                </div>
                <div class="form-group mb-3">
                    <label for="contenido_leccion" class="form-label">Descripción</label>
                    <textarea class="form-control" name="contenido_leccion[]" placeholder="Descripción" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label for="archivo_leccion" class="form-label">Archivo de la lección</label>
                    <input type="file" class="form-control" name="archivo_leccion[]" required>
                </div>
                <button type="button" class="btn btn-danger" onclick="eliminarLeccion(this)">Eliminar lección</button>
            </div>
        </div>
    `;

    // Convertir el HTML a un elemento DOM
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = nuevaLeccionHTML.trim();

    // Agregar la nueva lección al contenedor
    leccionesDiv.appendChild(tempDiv.firstChild);
}

/**
 * Elimina una lección del formulario de lecciones.
 * @param {HTMLElement} button - El botón que desencadena la eliminación.
 */
function eliminarLeccion(button) {
    // Eliminar la lección correspondiente
    const leccionesDiv = document.getElementById('lecciones');
    leccionesDiv.removeChild(button.closest('.col-md-12'));
}
