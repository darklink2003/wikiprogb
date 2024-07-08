<?php
// Inicia la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../controller/controlador.php?seccion=seccion2&error=not_logged_in");
    exit();
}
?>
<div class="contenedor_ayuda-12" style="background-color:#232230; color:white; width: 100%;">
    <div class="row">
        <div class="col-md-12 d-flex align-items-center">
            <h1>AYUDA</h1>
            <img src="../css/img/ayuda.png" alt="ayuda_pregunta" width="50px" height="50px">
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <ul style="list-style-type: none; color: white; padding: 20px;">
                <li style="margin: 5px 0;"><a href="#" style="color: white; text-decoration: none;">Cuenta y Perfil</a></li>
                <li style="margin: 5px 0;"><a href="archivos.html" style="color: white; text-decoration: none;">Nube</a></li>
                <li style="margin: 5px 0;"><a href="termino.html" style="color: white; text-decoration: none;">Políticas del sitio</a></li>
                <li style="margin: 5px 0;"><a href="https://code.visualstudio.com/download" style="color: white; text-decoration: none;">Aplicacion</a></li>
                <li style="margin: 5px 0;"><a href="entrevista.html" style="color: white; text-decoration: none;">Entrevista</a></li>
                <li style="margin: 5px 0;"><a href="index.php" style="color: white; text-decoration: none;">Curso</a></li>
                <li style="margin: 5px 0;"><a href="#" style="color: white; text-decoration: none;">Soporte</a></li>
            </ul>
        </div>
        <div class="col-md-9">
            <div class="row" style="border: 1px solid white; ">
                <div class="col-md-4" style="margin-top: 15%;">
                    <p style="font-size: 20px; font-family: calibri;">
                        AQUÍ ENCONTRARAS LAS SOLUCIONES A TUS PROBLEMAS
                    </p>
                </div>
                <div class="col-md-8 d-flex justify-content-center align-items-center">
                    <img src="../css/img/ayuda2.png" alt="" class="img-fluid">
                </div>
            </div>
            <div class="row" style="border: 1px solid white;">
                <div class="col text-center">
                    <h1>SOLUCION</h1>
                </div>
            </div>
        </div>
    </div>
</div>
