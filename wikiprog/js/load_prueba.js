document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const curso_id = urlParams.get('curso_id');
    const inscripción_id = urlParams.get('inscripción_id');
    const prueba_id = urlParams.get('prueba_id');

    function cargarPruebas(curso_id) {
        if (!curso_id) {
            console.error('No se proporcionó un curso_id válido.');
            return;
        }

        // Mostrar indicador de carga
        const pruebasContainer = document.getElementById('pruebas-container');
        pruebasContainer.innerHTML = '<p>Loading...</p>';

        axios.get(`../model/get_pruebas.php?curso_id=${curso_id}`)
            .then(function (response) {
                pruebasContainer.innerHTML = '';

                if (response.data.length > 0) {
                    response.data.forEach(function (prueba) {
                        const pruebaItem = document.createElement('div');
                        pruebaItem.classList.add('container', 'prueba-item');

                        const rowTitulo = document.createElement('div');
                        rowTitulo.classList.add('row');
                        const titulo = document.createElement('h2');
                        titulo.textContent = prueba.titulo_prueba;
                        rowTitulo.appendChild(titulo);

                        const rowContenido = document.createElement('div');
                        rowContenido.classList.add('row');
                        const contenido = document.createElement('h1');
                        contenido.textContent = prueba.contenido;
                        rowContenido.appendChild(contenido);

                        const rowFecha = document.createElement('div');
                        rowFecha.classList.add('row');
                        const fecha = document.createElement('h1');
                        fecha.textContent = prueba.fec_reg;
                        rowFecha.appendChild(fecha);

                        const rowDescargar = document.createElement('div');
                        rowDescargar.classList.add('row');
                        const enlaceDescarga = document.createElement('a');
                        enlaceDescarga.textContent = 'Descargar';
                        enlaceDescarga.href = `../archivos_prueba/${prueba.archivo_prueba}`;
                        enlaceDescarga.setAttribute('download', '');
                        enlaceDescarga.classList.add('btn', 'btn-primary', 'btn-sm');
                        rowDescargar.appendChild(enlaceDescarga);

                        pruebaItem.appendChild(rowTitulo);
                        pruebaItem.appendChild(rowContenido);
                        pruebaItem.appendChild(rowFecha);
                        pruebaItem.appendChild(rowDescargar);

                        pruebasContainer.appendChild(pruebaItem);
                    });

                    // Configurar el valor oculto
                    const pruebaIdInput = document.getElementById('prueba_id');
                    if (pruebaIdInput) {
                        pruebaIdInput.value = response.data[0].prueba_id;
                    }

                } else {
                    pruebasContainer.innerHTML = '<p>No se encontraron pruebas para este curso.</p>';
                }
            })
            .catch(function (error) {
                console.error('Error al cargar las pruebas:', error);
                pruebasContainer.innerHTML = '<p>Hubo un error al cargar las pruebas. Por favor, intenta nuevamente más tarde.</p>';
            });
    }

    function cargarRespuestas(inscripción_id) {
        if (!inscripción_id) {
            console.error('No se proporcionó un inscripción_id válido.');
            return;
        }

        // Mostrar indicador de carga
        const respuestasContainer = document.getElementById('respuestas-container');
        respuestasContainer.innerHTML = '<p>Loading...</p>';

        axios.get(`../model/get_respuestas.php?inscripción_id=${inscripción_id}`)
            .then(function (response) {
                respuestasContainer.innerHTML = '';

                if (response.data.length > 0) {
                    response.data.forEach(function (respuesta) {
                        const respuestaItem = document.createElement('div');
                        respuestaItem.classList.add('container', 'respuesta-item');

                        const rowArchivo = document.createElement('div');
                        rowArchivo.classList.add('row');
                        const archivo = document.createElement('h2');
                        archivo.textContent = respuesta.archivo_respuesta;
                        rowArchivo.appendChild(archivo);

                        const rowFecha = document.createElement('div');
                        rowFecha.classList.add('row');
                        const fecha = document.createElement('h1');
                        fecha.textContent = respuesta.fec_reg;
                        rowFecha.appendChild(fecha);

                        const rowDescargar = document.createElement('div');
                        rowDescargar.classList.add('row');
                        const enlaceDescarga = document.createElement('a');
                        enlaceDescarga.textContent = 'Descargar';
                        enlaceDescarga.href = `../archivos_respuesta/${respuesta.archivo_respuesta}`;
                        enlaceDescarga.setAttribute('download', '');
                        enlaceDescarga.classList.add('btn', 'btn-primary', 'btn-sm');
                        rowDescargar.appendChild(enlaceDescarga);

                        const rowEliminar = document.createElement('div');
                        rowEliminar.classList.add('row');
                        const btnEliminar = document.createElement('button');
                        btnEliminar.textContent = 'Eliminar';
                        btnEliminar.classList.add('btn', 'btn-danger', 'btn-sm');
                        btnEliminar.dataset.respuestaId = respuesta.respuesta_id; // Agregar ID para eliminar
                        btnEliminar.addEventListener('click', function () {
                            eliminarRespuesta(respuesta.respuesta_id);
                        });
                        rowEliminar.appendChild(btnEliminar);

                        respuestaItem.appendChild(rowArchivo);
                        respuestaItem.appendChild(rowFecha);
                        respuestaItem.appendChild(rowDescargar);
                        respuestaItem.appendChild(rowEliminar);

                        respuestasContainer.appendChild(respuestaItem);
                    });

                } else {
                    respuestasContainer.innerHTML = '<p>No se encontraron respuestas para esta inscripción.</p>';
                }
            })
            .catch(function (error) {
                console.error('Error al cargar las respuestas:', error);
                respuestasContainer.innerHTML = '<p>Hubo un error al cargar las respuestas. Por favor, intenta nuevamente más tarde.</p>';
            });
    }

    function eliminarRespuesta(respuesta_id) {
        if (!respuesta_id) {
            console.error('No se proporcionó un respuesta_id válido.');
            return;
        }

        if (confirm('¿Estás seguro de que quieres eliminar esta respuesta?')) {
            axios.post('../model/eliminar_respuesta.php', {
                respuesta_id: respuesta_id
            })
            .then(function (response) {
                if (response.data.success) {
                    alert('Respuesta eliminada exitosamente.');
                    cargarRespuestas(inscripción_id); // Recargar respuestas
                } else {
                    alert('Error al eliminar la respuesta.');
                }
            })
            .catch(function (error) {
                console.error('Error al eliminar la respuesta:', error);
                alert('Hubo un error al eliminar la respuesta. Por favor, intenta nuevamente más tarde.');
            });
        }
    }

    if (curso_id) {
        cargarPruebas(curso_id);
    }

    if (inscripción_id) {
        cargarRespuestas(inscripción_id);
    }

    // Configurar el valor de inscripción_id en el formulario
    const inscripcionInput = document.getElementById('inscripción_id');
    if (inscripción_id) {
        inscripcionInput.value = inscripción_id;
    } else {
        console.error('No se proporcionó un inscripción_id válido.');
    }
});
