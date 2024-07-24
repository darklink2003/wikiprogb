document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const curso_id = urlParams.get('curso_id');
    const inscripción_id = urlParams.get('inscripción_id'); // Asegúrate de pasar este valor en la URL o definirlo de alguna manera

    function cargarPruebas(curso_id) {
        if (!curso_id) {
            console.error('No se proporcionó un curso_id válido.');
            return;
        }

        axios.get(`../model/get_pruebas.php?curso_id=${curso_id}`)
            .then(function (response) {
                const pruebasContainer = document.getElementById('pruebas-container');
                pruebasContainer.innerHTML = '';

                if (response.data.length > 0) {
                    response.data.forEach(function (prueba, index) {
                        const pruebaItem = document.createElement('div');
                        pruebaItem.classList.add('container');
                        pruebaItem.style.backgroundColor = 'black';
                        pruebaItem.style.padding = '10px';
                        pruebaItem.style.borderRadius = '15px';
                        pruebaItem.style.marginBottom = '15px';

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

                    // Establece el valor de prueba_id en el formulario
                    document.getElementById('prueba_id').value = response.data[0].prueba_id; // Asigna el primer id de prueba; ajusta según tu lógica

                } else {
                    // Mostrar mensaje si no se encontraron pruebas
                    const noPruebasMsg = document.createElement('p');
                    noPruebasMsg.textContent = 'No se encontraron pruebas para este curso.';
                    pruebasContainer.appendChild(noPruebasMsg);
                }
            })
            .catch(function (error) {
                // Manejo de errores en la solicitud GET
                console.error('Error al cargar las pruebas:', error);
                const pruebasContainer = document.getElementById('pruebas-container');
                const errorMsg = document.createElement('p');
                errorMsg.textContent = 'Hubo un error al cargar las pruebas. Por favor, intenta nuevamente más tarde.';
                pruebasContainer.appendChild(errorMsg);
            });
    }

    // Llamar a la función para cargar pruebas al cargar la página
    cargarPruebas(curso_id);

    // Establece el valor de inscripción_id en el formulario
    const inscripcionInput = document.getElementById('inscripción_id');
    if (inscripción_id) {
        inscripcionInput.value = inscripción_id;
    } else {
        console.error('No se proporcionó un inscripción_id válido.');
    }
});
