<!-- seccion1.php -->
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
        <div id="cursos-container" class="row">
            <!-- Los cursos se cargarán aquí dinámicamente -->
        </div>
    </div>
</div>

<script type="text/template" id="curso-template">
    <div class="curso col-md-3">
        <h2 class="titulo-curso"></h2>
        <p class="descripcion-curso"></p>
        <div style="display: flex; align-items: center;">
            <button type="button" class="btn btn-primary like-button">▲</button>
            <h2 class="numerodelike" style="margin: 0 10px;"></h2>
            <button type="button" class="btn btn-primary dislike-button ml-2">▼</button>
            <h2 class="numerodedislike" style="margin: 0 10px;"></h2>
        </div>
        <a href="#" class="ver-lecciones-link">Ver lecciones</a>
    </div>
</script>

