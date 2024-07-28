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

function mostrarIndicadorCarga(mostrar) {
    const indicadorCarga = document.getElementById('indicador-carga');
    indicadorCarga.style.display = mostrar ? 'block' : 'none';
}

function mostrarMensajeError(mensaje, error) {
    const errorContainer = document.getElementById('error-container');
    errorContainer.textContent = mensaje;
    console.error(error);
}

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

function obtenerInteracciones(cursoId, cursoDiv) {
    fetch(`../model/get_interacion.php?curso_id=${cursoId}`)
        .then(response => response.json())
        .then(data => {
            cursoDiv.querySelector('.like-count').textContent = `Likes: ${data.like}`;
            cursoDiv.querySelector('.dislike-count').textContent = `Dislikes: ${data.dislike}`;
        })
        .catch(error => console.error('Error fetching interactions:', error));
}

function likeCurso(cursoId) {
    const usuarioId = 1; // Reemplaza con el ID del usuario actual
    fetch('../model/guardar_interacion.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            curso_id: cursoId,
            usuario_id: usuarioId,
            tipo_interaccion: 'like'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const cursoDiv = document.querySelector(`.curso[data-curso-id="${cursoId}"]`);
            obtenerInteracciones(cursoId, cursoDiv); // Obtener el conteo actualizado
        } else {
            console.error('Error:', data.message);
        }
    })
    .catch(error => console.error('Error liking course:', error));
}

function dislikeCurso(cursoId) {
    const usuarioId = 1; // Reemplaza con el ID del usuario actual
    fetch('../model/guardar_interacion.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            curso_id: cursoId,
            usuario_id: usuarioId,
            tipo_interaccion: 'dislike'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const cursoDiv = document.querySelector(`.curso[data-curso-id="${cursoId}"]`);
            obtenerInteracciones(cursoId, cursoDiv); // Obtener el conteo actualizado
        } else {
            console.error('Error:', data.message);
        }
    })
    .catch(error => console.error('Error disliking course:', error));
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
    // Eliminar la lección correspondiente
    const leccionesDiv = document.getElementById('lecciones');
    leccionesDiv.removeChild(button.closest('.col-md-12'));
}
