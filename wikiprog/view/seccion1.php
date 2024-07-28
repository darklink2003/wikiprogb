<style>
    .btn-like {
        background-color: #28a745; /* Color verde para "like" */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 15px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-dislike {
        background-color: #dc3545; /* Color rojo para "dislike" */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 15px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-like:hover {
        background-color: #218838; /* Color más oscuro para "like" al pasar el mouse */
    }

    .btn-dislike:hover {
        background-color: #c82333; /* Color más oscuro para "dislike" al pasar el mouse */
    }

    .btn-like:focus,
    .btn-dislike:focus {
        outline: none; /* Quitar el borde de enfoque */
    }
</style>

<div class="container">
    <!-- Barra de búsqueda -->
    <div class="row">
        <div class="col">
            <form action="#" method="GET" class="d-flex" id="form-busqueda">
                <input type="search" class="form-control me-2" name="q" placeholder="Buscar...">
                <button type="submit" class="btn btn-dark">Buscar</button>
            </form>
        </div>
    </div>

    <!-- Contenedor de cursos -->
    <div class="row mt-3">
        <div id="cursos-container"></div>
        <div id="indicador-carga" style="display: none;">Cargando...</div>
        <div id="error-container" style="color: red;"></div>
    </div>
</div>

<!-- Plantilla para los cursos -->
<script type="text/template" id="curso-template">
    <div class="curso" data-curso-id="{curso_id}">
        <h2 class="titulo-curso"></h2>
        <p class="descripcion-curso"></p>
        <a class="ver-lecciones-link" href="#">Ver lecciones</a>
        <div class="reacciones">
            <button class="btn-like" onclick="likeCurso({curso_id})">Like</button>
            <span class="like-count">Likes: 0</span>
            <button class="btn-dislike" onclick="dislikeCurso({curso_id})">Dislike</button>
            <span class="dislike-count">Dislikes: 0</span>
        </div>
    </div>
</script>

<script src="../js/funciones.js"></script>
