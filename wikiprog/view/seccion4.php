<!-- seccion4.php -->

<!-- Formulario para la creación y edición de cursos -->
<div class="contenedor_descripcion">
    <form action="../model/guardar_curso.php" method="POST" enctype="multipart/form-data">
        <!-- Encabezado del formulario -->
        <div class="row" style="height:100px;background-color: #1a1924; border-radius:15px;">
            <!-- Columna izquierda para título y descripción -->
            <div class="col-md-8 d-flex justify-content-center align-items-center">
                <input type="text" name="titulo_curso" placeholder="Título del curso" required class="form-control"
                    style=" border-radius: 10px;">
                <input type="text" name="descripcion" placeholder="Descripción" class="form-control"
                    style="margin-left:10px; border-radius: 10px;" required>
            </div>
            <!-- Columna derecha para selección de categoría y botón de eliminar curso -->
            <div class="col-md-4 d-flex justify-content-center align-items-center">
                <select name="categoria" required class="form-select"
                    style="background-color: #1a1924; color: white; border-radius: 10px;">
                    <?php
                    // Conexión a la base de datos
                    include '../model/db_config.php';

                    // Obtener las categorías
                    $sql = "SELECT categoria_id, descripcion FROM categoria";
                    $resultado = $conn->query($sql);

                    if ($resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            echo '<option value="' . $row['categoria_id'] . '">' . $row['descripcion'] . '</option>';
                        }
                    }

                    // Cerrar la conexión
                    $conn->close();
                    ?>
                </select>
                <button type="button" onclick="eliminarCurso()" class="btn btn-danger"
                    style="border-radius: 10px;height:40%;width:90%;margin-left:10px;">Eliminar curso</button>
            </div>
        </div>

        <br>
        <!-- Contenedor de lecciones -->
        <div class="contenedorleccion"
            style="display: flex; flex-wrap: wrap; background-color:#1a1924; border-radius:10px; padding: 10px;">
            <div class="row">
                <h3 style="color: white;">Lecciones</h3>
            </div><br>
            <div class="row">
                <div class="row">
                    <div id="lecciones">
                        <!-- Aquí se agregarán las lecciones dinámicamente -->
                    </div><br>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" onclick="agregarLeccion()" class="btn btn-primary"
                            style="margin-top: 10px; border-radius: 10px;">Agregar otra lección</button>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- Botón de envío del formulario -->
        <input type="submit" value="Enviar" class="btn btn-success">
    </form>
</div>

<!-- Plantilla de curso para el frontend -->
<script type="text/template" id="curso-template">
    <div class="curso">
        <h2 class="titulo-curso"></h2>
        <p class="descripcion-curso"></p>
        <button class="like-button">Me gusta</button>
        <button class="dislike-button">No me gusta</button>
        <a href="#" class="ver-lecciones-link">Ver lecciones</a>
    </div>
</script>


