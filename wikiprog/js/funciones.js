// funciones.js

document.addEventListener('DOMContentLoaded', function() {
    cargarCursos(); // Cargar cursos al cargar la página

    const formBusqueda = document.getElementById('form-busqueda');

    formBusqueda.addEventListener('submit', function(event) {
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

function cargarCursos() {
    fetch('../model/get_courses.php')
        .then(response => response.json())
        .then(data => {
            renderCursos(data);
        })
        .catch(error => {
            console.error('Error fetching courses:', error);
        });
}

function renderCursos(data) {
    const cursosContainer = document.getElementById('cursos-container');
    const cursoTemplate = document.getElementById('curso-template').innerHTML;

    cursosContainer.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos cursos

    data.forEach(curso => {
        // Crear un contenedor temporal para usar el innerHTML
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = cursoTemplate;

        const cursoDiv = tempDiv.firstElementChild;

        // Reemplazar contenido dinámico del curso
        cursoDiv.querySelector('.titulo-curso').textContent = curso.titulo_curso;
        cursoDiv.querySelector('.descripcion-curso').textContent = curso.descripcion;
        cursoDiv.querySelector('.numerodelike').textContent = curso.likes; // Mostrar los likes iniciales
        cursoDiv.querySelector('.numerodedislike').textContent = curso.dislikes; // Mostrar los dislikes iniciales
        cursoDiv.querySelector('.like-button').onclick = () => likeCurso(cursoDiv, curso.curso_id);
        cursoDiv.querySelector('.dislike-button').onclick = () => dislikeCurso(cursoDiv, curso.curso_id);
        cursoDiv.querySelector('.ver-lecciones-link').href = `../controller/controlador.php?seccion=seccion7&curso_id=${curso.curso_id}`;

        cursosContainer.appendChild(cursoDiv);
    });
}

function likeCurso(cursoDiv, cursoId) {
    // Lógica para manejar el like
    console.log(`Liked course ID: ${cursoId}`);
    // Actualizar contador de likes en la interfaz
    const likeCount = cursoDiv.querySelector('.numerodelike');
    likeCount.textContent = parseInt(likeCount.textContent) + 1;
}

function dislikeCurso(cursoDiv, cursoId) {
    // Lógica para manejar el dislike
    console.log(`Disliked course ID: ${cursoId}`);
    // Actualizar contador de dislikes en la interfaz
    const dislikeCount = cursoDiv.querySelector('.numerodedislike');
    dislikeCount.textContent = parseInt(dislikeCount.textContent) + 1;
}

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

function eliminarLeccion(button) {
    const leccion = button.parentElement.parentElement;
    leccion.remove();
}

function eliminarCurso() {
    if (confirm("¿Estás seguro de que deseas eliminar el curso? Esta acción no se puede deshacer.")) {
        // Aquí puedes agregar la lógica para eliminar el curso
    }
}
