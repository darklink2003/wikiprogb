<?php
// mensajes.php

function mostrarAlerta($tipo, $titulo, $texto, $redireccion)
{
    echo "<script>
        Swal.fire({
            icon: '$tipo',
            title: '$titulo',
            text: '$texto',
            confirmButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '$redireccion';
            }
        });
    </script>";
}

function alertaCuentaBloqueada()
{
    mostrarAlerta('error', 'Cuenta bloqueada', 'Tu cuenta ha sido bloqueada debido a múltiples intentos fallidos. Por favor, contacta al administrador.', 'controlador.php?seccion=seccion3');
}

function alertaInicioExitoso()
{
    mostrarAlerta('success', 'Inicio de sesión exitoso', 'Has iniciado sesión correctamente.', 'controlador.php?seccion=seccion1');
}

function alertaContrasenaIncorrecta()
{
    mostrarAlerta('error', 'Contraseña incorrecta', 'La contraseña ingresada es incorrecta.', 'controlador.php?seccion=seccion2');
}

function alertaUsuarioNoEncontrado($usuario)
{
    mostrarAlerta('error', 'Usuario no encontrado', 'El usuario ingresado no existe: $usuario', 'controlador.php?seccion=seccion3');
}

function alertaCamposVacios()
{
    mostrarAlerta('warning', 'Campos vacíos', 'Por favor, ingresa nombre de usuario y contraseña.', 'controlador.php?seccion=seccion4');
}
function alertaArchivoSubido($usuario_id)
{
    $url = '../controller/controlador.php?seccion=seccion12&usuario_id=' . urlencode($usuario_id);
    mostrarAlerta('success', 'Archivo subido correctamente', 'El archivo se ha subido exitosamente.', $url);
}

function alertaErrorArchivo($mensaje)
{
    mostrarAlerta('error', 'Error al subir el archivo', $mensaje, 'javascript:history.back()');
}

function alertaArchivoEliminado($redirectUrl)
{
    mostrarAlerta('success', 'Archivo eliminado', 'El archivo se ha eliminado exitosamente.', $redirectUrl);
}

function alertaErrorEliminarArchivo($mensaje)
{
    mostrarAlerta('error', 'Error al eliminar el archivo', $mensaje, 'javascript:history.back()');
}

function alertaArchivoNoEncontrado($archivo_id)
{
    mostrarAlerta('error', 'Archivo no encontrado', "No se encontró el archivo con ID $archivo_id.", 'javascript:history.back()');
}

function alertaExitoActualizacion($redirectUrl)
{
    mostrarAlerta('success', 'Actualización exitosa', 'Datos actualizados con éxito.', $redirectUrl);
}

function alertaError($errores, $redirectUrl)
{
    $mensajeErrores = implode(' ', $errores);
    mostrarAlerta('error', 'Error en la actualización', $mensajeErrores, $redirectUrl);
}

function alertaErrorSesion()
{
    mostrarAlerta('error', 'Sesión no iniciada', 'Debe iniciar sesión para continuar.', '../controller/controlador.php?seccion=seccion2&error=not_logged_in');
}
?>