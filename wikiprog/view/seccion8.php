<div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Formulario de Inscripción
                    </div>
                    <div class="card-body">
                        <form action="procesar_inscripcion.php" method="POST">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>

                            <div class="form-group">
                                <label for="curso">Curso de Interés:</label>
                                <p>nombre del curso</p>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar Inscripción</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>