<?php
// Inicia la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: controlador.php?seccion=seccion2&error=not_logged_in");
    exit();
}
?>
<div class="container-fluid" style="padding-left: 0px; padding-right:0px;background-color:#232230;color:white;">
        <div class="container" style="max-width: 98%;">
            <div class="row">
                <div class="col-md-2">
                    <div id="izquierda">
                        <h1 style="font-size: 20px;">
                            TU NUBE
                        </h1>
                        <hr>
                        <a href="controlador.php?seccion=seccion1" class="enlace">Inicio</a><br>
                        <a href="#" class="enlace">Mis Archivos</a><br>
                        <a href="#" class="enlace">Mis Cursos</a><br>
                    </div>
                </div>
                <div class="col-md-10" style="padding-left: 11px; border:1px solid white; width:80%">
                    <div class="row border-bottom mb-2">
                        <div class="col-md-8 d-flex align-items-center" style="height:40px;">
                            <p class="mb-0">Mis Archivos</p>
                            <div class="input-with-icon">
                                <input type="text" class="form-control ms-2" id="busqueda">
                            </div>
                        </div>
                        <div class="col-md-4" style="display: flex; padding-left:90%px; height:40px;text-aling-ringt">
                            <input class="btn btn-primary" type="file" name="cargar" id="" >
                        </div>

                    </div>
                    <div class="row border-bottom mb-2">
                        <div class="col-md-4">
                            <p class="columna-titulo">Nombre ▼</p>
                        </div>
                        <div class="col-md-4">
                            <p class="columna-titulo">Modificado ▼</p>
                        </div>
                        <div class="col-md-4">
                            <p class="columna-titulo">Tamaño ▼</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <p>Nombre </p>
                        </div>
                        <div class="col-md-4">
                            <p>fecha de modificacion </p>
                        </div>
                        <div class="col-md-4">
                            <p>Tamaño </p>
                        </div>
                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>