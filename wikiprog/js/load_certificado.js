document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const usuario_id = urlParams.get('usuario_id');

    function mostrarCertificado(inscripcion) {
        const container = document.getElementById('certificate-container');
        let mensajeNota = `Nota obtenida: ${inscripcion.nota}`;
        let textoColor = 'black';
        let imagenCertificado = '';

        if (inscripcion.nota < 15) {
            mensajeNota = "Certificado no aprobado";
            textoColor = 'red';
            imagenCertificado = '<img src="../css/img/noaprovado.png" alt="Certificado No Aprobado" width="300px">';
        } else {
            imagenCertificado = '<img src="../css/img/aprovado.png" alt="Certificado Aprobado" width="300px">';
        }

        container.innerHTML = `
            <div id="certificado" class="certificate" style="color: ${textoColor}; display:flex;">
                <div class="col-md-4" style="text-align: center;">
                    ${imagenCertificado}
                </div>
                <div class="col-md-4">
                    <h1 class="mb-4">Certificado de aprobación</h1>
                    <p>${mensajeNota}</p>
                    <h2>${inscripcion.nombre}</h2>
                    <p>ha sido reconocido con el presente certificado por su participación en el curso de ${inscripcion.titulo_curso}</p>
                    <p class="award">¡Felicidades!</p>
                </div>
            </div>
            <button id="downloadButton" class="btn btn-primary">Descargar Certificado</button>
        `;

        document.getElementById('downloadButton').addEventListener('click', function () {
            descargarCertificado();
        });
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
                    const inscripcion = response.data[0];
                    console.log('Inscripción seleccionada:', inscripcion);
                    mostrarCertificado({
                        nota: inscripcion.nota,
                        nombre: inscripcion.nombre,
                        titulo_curso: inscripcion.titulo_curso,
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

    function descargarCertificado() {
        const certificado = document.getElementById('certificado');
        html2canvas(certificado).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF();
            pdf.addImage(imgData, 'PNG', 0, 0);
            pdf.save('certificado.pdf');
        });
    }

    cargarCertificado(usuario_id);
});
