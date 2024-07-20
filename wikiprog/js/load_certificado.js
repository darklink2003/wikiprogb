
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const usuario_id = urlParams.get('usuario_id');

    function mostrarCertificado(inscripcion) {
        const container = document.getElementById('certificate-container');
        container.innerHTML = `
            <div class="certificate">
                <h1 class="mb-4">Certificado de Excelencia</h1>
                <p>${inscripcion.nota}</p>
                <h2>${inscripcion.nombre}</h2>
                <p>ha sido reconocido con el presente certificado por su participación en el curso de ${inscripcion.titulo_curso}</p>
                <p class="award">¡Felicidades!</p>
                <div class="signature">
                    <p>${inscripcion.creador_curso}</p>
                    <hr>
                    <p>${inscripcion.evaluador}</p>
                </div>
            </div>
        `;
    }

    function cargarCertificado(usuario_id) {
        if (!usuario_id) {
            console.error('No se proporcionó un usuario_id válido.');
            return;
        }

        axios.get(`../model/get_inscripcion.php?usuario_id=${usuario_id}`)
            .then(function (response) {
                console.log('Datos de la respuesta:', response.data);
                if (response.data && response.data.length > 0) {
                    // Asumiendo que tomamos la primera inscripción para mostrar el certificado
                    const inscripcion = response.data[0];
                    console.log('Inscripción seleccionada:', inscripcion);
                    mostrarCertificado({
                        nota: inscripcion.nota,
                        nombre: inscripcion.nombre,
                        titulo_curso: inscripcion.titulo_curso,
                        creador_curso: 'Nombre del Creador del Curso',
                        evaluador: 'Nombre del Evaluador'
                    });
                } else {
                    console.error('No se encontró información del certificado.');
                    document.getElementById('certificate-container').innerText = 'No se encontró información del certificado.';
                }
            })
            .catch(function (error) {
                console.error('Error al cargar el certificado:', error);
                const container = document.getElementById('certificate-container');
                container.innerHTML = '';
                const errorMsg = document.createElement('p');
                errorMsg.textContent = 'Hubo un error al cargar el certificado. Por favor, intenta nuevamente más tarde.';
                container.appendChild(errorMsg);
            });
    }

    cargarCertificado(usuario_id);
});