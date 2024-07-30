document.addEventListener('DOMContentLoaded', function () {
  const urlParams = new URLSearchParams(window.location.search);
  const usuario_id = urlParams.get('usuario_id');

  function cargarInscripciones(usuario_id) {
    if (!usuario_id) {
      console.error('No se proporcionó un usuario_id válido.');
      return;
    }

    axios.get(`../model/get_inscripcion.php?usuario_id=${usuario_id}`)
      .then(function (response) {
        const inscripcionesContainer = document.getElementById('inscripcion-container');
        inscripcionesContainer.innerHTML = '';

        if (response.data.length > 0) {
          response.data.forEach(function (inscripcion, index) {
            const inscripcionItem = document.createElement('div');
            inscripcionItem.classList.add('inscripcion-item', 'p-3', 'mb-3', 'rounded', 'shadow-sm');

            const backgroundColor = index % 2 === 0 ? '#343a40' : '#3d434a';
            const textColor = '#f8f9fa';
            inscripcionItem.style.backgroundColor = backgroundColor;
            inscripcionItem.style.color = textColor;

            const rowDiv = document.createElement('div');
            rowDiv.classList.add('row');

            // Columna 1: Nombre del curso
            const col1Div = document.createElement('div');
            col1Div.classList.add('col-md-2', 'col-sm-6');
            const nombreCurso = document.createElement('p');
            nombreCurso.innerHTML = `<strong>Curso:</strong> ${inscripcion.titulo_curso}`;
            col1Div.appendChild(nombreCurso);

            // Columna 2: Nota
            const col2Div = document.createElement('div');
            col2Div.classList.add('col-md-2', 'col-sm-6');
            const nota = document.createElement('p');
            nota.innerHTML = `<strong>Nota:</strong> ${inscripcion.nota}`;
            col2Div.appendChild(nota);

            // Columna 3: Tiempo Transcurrido
            const col3Div = document.createElement('div');
            col3Div.classList.add('col-md-4');
            const tiempoTranscurrido = document.createElement('p');
            tiempoTranscurrido.innerHTML = `<strong>Tiempo Transcurrido:</strong> ${inscripcion.tiempo_transcurrido}`;
            col3Div.appendChild(tiempoTranscurrido);

            // Columna 4: Acciones
            const col4Div = document.createElement('div');
            col4Div.classList.add('col-md-4', 'col-sm-12', 'text-end');

            // Enlaces de acción
            const enlaceCurso = document.createElement('a');
            enlaceCurso.textContent = 'Ir al curso';
            enlaceCurso.href = `../controller/controlador.php?seccion=seccion7&curso_id=${inscripcion.curso_id}`;
            enlaceCurso.classList.add('btn', 'btn-info', 'btn-sm', 'ms-1');
            col4Div.appendChild(enlaceCurso);

            const enlacePrueba = document.createElement('a');
            enlacePrueba.textContent = 'Ir a la prueba';
            enlacePrueba.href = `../controller/controlador.php?seccion=seccion16&curso_id=${inscripcion.curso_id}&inscripción_id=${inscripcion.inscripción_id}&usuario_id=${usuario_id}`;
            enlacePrueba.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-1');
            col4Div.appendChild(enlacePrueba);

            const enlaceCertificado = document.createElement('a');
            enlaceCertificado.textContent = 'Abrir Certificado';
            enlaceCertificado.href = `../controller/controlador.php?seccion=seccion15&usuario_id=${usuario_id}`;
            enlaceCertificado.classList.add('btn', 'btn-success', 'btn-sm', 'ms-1');
            col4Div.appendChild(enlaceCertificado);

            // Añadir columnas a la fila
            rowDiv.appendChild(col1Div);
            rowDiv.appendChild(col2Div);
            rowDiv.appendChild(col3Div);
            rowDiv.appendChild(col4Div);

            // Añadir fila al contenedor de inscripciones
            inscripcionItem.appendChild(rowDiv);
            inscripcionesContainer.appendChild(inscripcionItem);
          });
        } else {
          // Mostrar mensaje si no se encontraron inscripciones
          const noInscripcionesMsg = document.createElement('p');
          noInscripcionesMsg.textContent = 'No se encontraron inscripciones para este usuario.';
          noInscripcionesMsg.style.color = '#f8f9fa';
          inscripcionesContainer.appendChild(noInscripcionesMsg);
        }
      })
      .catch(function (error) {
        // Manejo de errores en la solicitud GET
        console.error('Error al cargar las inscripciones:', error);
        const inscripcionesContainer = document.getElementById('inscripcion-container');
        inscripcionesContainer.innerHTML = ''; // Limpiar el contenedor antes de mostrar el mensaje de error
        const errorMsg = document.createElement('p');
        errorMsg.textContent = 'Hubo un error al cargar las inscripciones. Por favor, intenta nuevamente más tarde.';
        errorMsg.style.color = '#f8f9fa';
        inscripcionesContainer.appendChild(errorMsg);
      });
  }

  cargarInscripciones(usuario_id);
});
