<!-- seccion16.php -->
<div class="container" style="background-color:black; padding:10px; border-radius:15px;">
    <div class="row">
        <div id="pruebas-container" class="pruebas-container" style="padding:30px;">
            <!-- Aquí se cargarán las pruebas desde JavaScript -->
        </div>
    </div>
    <div class="row">
        <div class="formulario-container" style="padding:30px;">
            <form id="formulario-respuesta" action="../model/guardar_respuesta.php" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="prueba_id" id="prueba_id" value="">
                <!-- Asegúrate de establecer este valor con JavaScript -->
                <input type="hidden" name="inscripcion_id" id="inscripcion_id" value="">
                <!-- Asegúrate de establecer este valor con JavaScript -->
                <div class="mb-3">
                    <label for="archivo_respuesta" class="form-label" style="color: white;">Archivo de Respuesta</label>
                    <input type="file" class="form-control" id="archivo_respuesta" name="archivo_respuesta" required>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Guardar Respuesta</button>
            </form>
        </div>
    </div>
</div>