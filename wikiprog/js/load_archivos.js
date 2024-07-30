// load_archivos.js
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const usuario_id = urlParams.get('usuario_id');
    /**
     * Carga y muestra los archivos asociados con un usuario.
     * @param {string} usuario_id - El ID del usuario cuyos archivos se deben cargar.
     */
    function cargarArchivos(usuario_id) {
        if (!usuario_id) {
            console.error('No se proporcionó un usuario_id válido.');
            return;
        }

        axios.get(`../model/get_archivos.php?usuario_id=${usuario_id}`)
            .then(function (response) {
                const archivosContainer = document.getElementById('archivos-container');
                archivosContainer.innerHTML = '';

                if (response.data.length > 0) {
                    response.data.forEach(function (archivo, index) {
                        const archivoItem = document.createElement('div');
                        archivoItem.classList.add('archivo-container');

                        const backgroundColor = index % 2 === 0 ? '#282F44' : '#191D32';
                        archivoItem.style.backgroundColor = backgroundColor;

                        const rowDiv = document.createElement('div');
                        rowDiv.classList.add('row');

                        // Columna 1: Nombre del archivo
                        const col1Div = document.createElement('div');
                        col1Div.classList.add('col-md-2');
                        const nombreArchivo = document.createElement('p');
                        nombreArchivo.innerHTML = `<strong>Nombre:</strong> ${archivo.nombre_archivo}`;
                        col1Div.appendChild(nombreArchivo);

                        // Columna 2: Tamaño del archivo
                        const col2Div = document.createElement('div');
                        col2Div.classList.add('col-md-2');
                        const tamañoArchivo = document.createElement('p');
                        tamañoArchivo.innerHTML = `<strong>Tamaño:</strong><br> ${archivo.tamaño}`;
                        col2Div.appendChild(tamañoArchivo);

                        // Columna 3: Fecha de registro
                        const col3Div = document.createElement('div');
                        col3Div.classList.add('col-md-3');
                        const fechaRegistro = document.createElement('p');
                        fechaRegistro.innerHTML = `<strong>Fecha de Registro:</strong> ${archivo.fecha_registro}`;
                        col3Div.appendChild(fechaRegistro);

                        // Columna 4: Privacidad del archivo
                        const col4Div = document.createElement('div');
                        col4Div.classList.add('col-md-2');
                        const privacidad = document.createElement('p');
                        privacidad.innerHTML = `<strong>Privacidad:</strong> ${archivo.privacidad_id == 1 ? 'Privada' : 'Pública'}`;
                        col4Div.appendChild(privacidad);

                        // Columna 5: Acciones (Descargar y Eliminar)
                        const col5Div = document.createElement('div');
                        col5Div.classList.add('col-md-3', 'text-end');

                        // Botón de Descargar archivo
                        const enlaceDescarga = document.createElement('a');
                        enlaceDescarga.textContent = 'Descargar';
                        enlaceDescarga.href = `../archivos_usuarios/${archivo.nombre_archivo}`;
                        enlaceDescarga.setAttribute('download', '');
                        enlaceDescarga.classList.add('btn', 'btn-primary', 'btn-sm', 'ms-1');
                        col5Div.appendChild(enlaceDescarga);

                        // Botón de Eliminar archivo
                        const enlaceEliminar = document.createElement('a');
                        enlaceEliminar.textContent = 'Eliminar';
                        enlaceEliminar.href = `javascript:void(0);`;  // Enlace sin acción por defecto, puedes ajustar esto según tu lógica
                        enlaceEliminar.classList.add('btn', 'btn-danger', 'btn-sm', 'ms-1');
                        enlaceEliminar.addEventListener('click', function () {
                            eliminarArchivo(archivo.archivo_id);  // Llama a la función eliminarArchivo con el ID del archivo
                        });
                        col5Div.appendChild(enlaceEliminar);

                        // Añadir columnas a la fila
                        rowDiv.appendChild(col1Div);
                        rowDiv.appendChild(col2Div);
                        rowDiv.appendChild(col3Div);
                        rowDiv.appendChild(col4Div);
                        rowDiv.appendChild(col5Div);

                        // Añadir fila al contenedor de archivos
                        archivoItem.appendChild(rowDiv);
                        archivosContainer.appendChild(archivoItem);
                    });
                } else {
                    // Mostrar mensaje si no se encontraron archivos
                    const noArchivosMsg = document.createElement('p');
                    noArchivosMsg.textContent = 'No se encontraron archivos para este usuario.';
                    archivosContainer.appendChild(noArchivosMsg);
                }
            })
            .catch(function (error) {
                // Manejo de errores en la solicitud GET
                console.error('Error al cargar los archivos:', error);
                const archivosContainer = document.getElementById('archivos-container');
                const errorMsg = document.createElement('p');
                errorMsg.textContent = 'Hubo un error al cargar los archivos. Por favor, intenta nuevamente más tarde.';
                archivosContainer.appendChild(errorMsg);
            });
    }

    /**
     * Función para eliminar un archivo.
     * @param {number} archivoId - ID del archivo a eliminar.
     */
    function eliminarArchivo(archivoId) {
        if (confirm('¿Estás seguro de que deseas eliminar este archivo?')) {
            axios.delete(`../model/delte_archivo.php?archivo_id=${archivoId}`)
                .then(function (response) {
                    console.log(response.data);
                    // Recargar la lista de archivos después de eliminar
                    cargarArchivos(usuario_id);
                })
                .catch(function (error) {
                    console.error('Error al eliminar el archivo:', error);
                    alert('Hubo un error al eliminar el archivo. Intenta nuevamente más tarde.');
                });
        }
    }

    // Llamar a la función para cargar archivos al cargar la página
    cargarArchivos(usuario_id);
});
