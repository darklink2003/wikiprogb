<?php
/**
 * Clase Login para manejar operaciones relacionadas con usuarios en la base de datos.
 * clase.php
 * Esta clase permite registrar nuevos usuarios y recuperar datos de usuarios existentes.
 * 
 * @version 1.0
 * @author Pablo Alexander Mondragon Acevedo
 */

class Login
{
    /**
     * Registra un nuevo usuario en la base de datos.
     *
     * @param string $usuario El nombre de usuario.
     * @param string $correo La dirección de correo electrónico del usuario.
     * @param string $contraseña La contraseña del usuario.
     * @param int $rango_id El identificador del rango o rol del usuario.
     * @return void
     */
    public static function registrar($usuario, $correo, $contraseña, $rango_id)
    {
        // Incluir la configuración de la base de datos
        include 'db_config.php';

        // Consulta SQL para insertar un nuevo usuario en la tabla 'usuario'
        $sql = "INSERT INTO usuario (usuario, correo, contraseña, rango_id) VALUES ('$usuario', '$correo', '$contraseña', '$rango_id')";

        // Ejecución de la consulta
        $consulta = $conn->query($sql);

        // Redirección si la consulta se ejecuta correctamente
        if ($consulta) {
            header("Location: ../controller/controlador.php?seccion=seccion6");
        }
    }

    /**
     * Recupera y muestra los datos de todos los usuarios registrados en la base de datos.
     *
     * @return string Cadena de texto con los datos de todos los usuarios.
     */
    public static function verusuarios()
    {
        // Incluir la configuración de la base de datos
        include 'db_config.php';

        // Variable para almacenar la salida
        $salida = "";

        // Consulta SQL para seleccionar todos los usuarios de la tabla 'usuario'
        $sql = "SELECT usuario_id, usuario, img_usuario, correo, biografia, rango_id, fecha_registro, intentos_fallidos, cuenta_bloqueada FROM usuario";

        // Ejecución de la consulta
        $consulta = $conn->query($sql);


        // Construcción de la tabla HTML con los datos de los usuarios
        $salida = '<div class="container-fluid" style="max-width:110%;">';
        $salida .= '<div class="table-responsive">';
        $salida .= '<table class="table table-striped table-hover table-bordered">';
        $salida .= '<thead class="table-dark">';
        $salida .= '<tr>';
        $salida .= '<th scope="col">Usuario</th>';
        $salida .= '<th scope="col">Imagen</th>';
        $salida .= '<th scope="col">Correo</th>';
        $salida .= '<th scope="col">Biografía</th>';
        $salida .= '<th scope="col">Rango</th>';
        $salida .= '<th scope="col">Fecha de Registro</th>';
        $salida .= '<th scope="col">Intentos Fallidos</th>';
        $salida .= '<th scope="col">Cuenta Bloqueada</th>';
        $salida .= '<th scope="col">Editar</th>';
        $salida .= '<th scope="col">Eliminar</th>';
        $salida .= '</tr>';
        $salida .= '</thead>';
        $salida .= '<tbody>';

        while ($fila = $consulta->fetch_assoc()) {
            $usuario_id = $fila['usuario_id']; // Obtener el id del usuario

            // Asignar texto correspondiente al rango_id
            $rango_texto = isset($fila["rango_id"]) ?
                ($fila["rango_id"] == 1 ? "Usuario" :
                    ($fila["rango_id"] == 2 ? "Administrador" :
                        ($fila["rango_id"] == 3 ? "Evaluador" : "Desconocido")))
                : "Desconocido";

            // Convertir el valor de cuenta_bloqueada a texto
            $cuenta_bloqueada_texto = $fila['cuenta_bloqueada'] ? "Sí" : "No";

            $salida .= '<tr>';
            $salida .= '<td>' . htmlspecialchars($fila['usuario'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . htmlspecialchars($fila['img_usuario'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . htmlspecialchars($fila['correo'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . htmlspecialchars($fila['biografia'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . $rango_texto . '</td>';
            $salida .= '<td>' . htmlspecialchars($fila['fecha_registro'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . htmlspecialchars($fila['intentos_fallidos'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . $cuenta_bloqueada_texto . '</td>';
            $salida .= '<td><a href="../controller/controlador.php?seccion=seccion13&id=' . $usuario_id . '" class="btn btn-primary btn-sm">Editar</a></td>';
            $salida .= '<td><a href="../model/eliminar.php?id=' . $usuario_id . '" class="btn btn-danger btn-sm">Eliminar</a></td>';
            $salida .= '</tr>';
        }

        $salida .= '</tbody>';
        $salida .= '</table>';
        $salida .= '</div>'; // Cerrar el div table-responsive
        $salida .= '</div>'; // Cerrar el div container-fluid

        // Cerrar la conexión
        $conn->close();

        // Retornar la salida
        return $salida;
    }

    /**
     * Recupera y muestra los datos de todos los cursos registrados en la base de datos.
     *
     * @return string Cadena de texto con los datos de todos los cursos.
     */
    public static function vercursos()
    {
        // Incluir la configuración de la base de datos
        include 'db_config.php';

        // Variable para almacenar la salida
        $salida = "";

        // Consulta SQL para seleccionar todos los cursos de la tabla 'curso'
        $sql = "SELECT curso_id, titulo_curso, descripcion, categoria_id, fecha_registro, megusta, dislike, usuario_id FROM curso";

        // Ejecución de la consulta
        $consulta = $conn->query($sql);

        // Verificar si la consulta fue exitosa
        if (!$consulta) {
            die("Error en la consulta: " . $conn->query($sql));
        }

        // Construcción de la tabla HTML con los datos de los cursos
        $salida = '<div class="container-fluid" style="max-width:400vh;">';
        $salida .= '<div class="table-responsive">';
        $salida .= '<table class="table table-striped table-hover table-bordered">';
        $salida .= '<thead class="table-dark">';
        $salida .= '<tr>';
        $salida .= '<th scope="col">Titulo</th>';
        $salida .= '<th scope="col">Descripcion</th>';
        $salida .= '<th scope="col">Categoria</th>';
        $salida .= '<th scope="col">Fecha Registro</th>';
        $salida .= '<th scope="col">Megusta</th>';
        $salida .= '<th scope="col">Dislike</th>';
        $salida .= '<th scope="col">Usuario</th>';
        $salida .= '<th scope="col">Editar</th>';
        $salida .= '<th scope="col">Eliminar</th>';
        $salida .= '</tr>';
        $salida .= '</thead>';
        $salida .= '<tbody>';

        while ($fila = $consulta->fetch_assoc()) {
            $curso_id = $fila['curso_id']; // Obtener el id del curso

            // Asignar texto correspondiente al categoria_id
            $categoria_texto = isset($fila["categoria_id"]) ?
                ($fila["categoria_id"] == 1 ? "Código" :
                    ($fila["categoria_id"] == 2 ? "Lógica del programador" :
                        ($fila["categoria_id"] == 3 ? "Estilo" :
                            ($fila["categoria_id"] == 4 ? "Base de datos" :
                                ($fila["categoria_id"] == 5 ? "Otro" :
                                    ($fila["categoria_id"] == 6 ? "AJAX" : "Desconocido"))))))
                : "Desconocido";

            $salida .= '<tr>';
            $salida .= '<td>' . htmlspecialchars($fila['titulo_curso'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . htmlspecialchars($fila['descripcion'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . $categoria_texto . '</td>';
            $salida .= '<td>' . htmlspecialchars($fila['fecha_registro'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . htmlspecialchars($fila['megusta'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . htmlspecialchars($fila['dislike'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td>' . htmlspecialchars($fila['usuario_id'], ENT_QUOTES, 'UTF-8') . '</td>';
            $salida .= '<td><a href="../controller/controlador.php?seccion=seccion14&id=' . $curso_id . '" class="btn btn-primary btn-sm">Editar</a></td>';
            $salida .= '<td><a href="../model/eliminar_curso.php?id=' . $curso_id . '" class="btn btn-danger btn-sm">Eliminar</a></td>';
            $salida .= '</tr>';
        }

        $salida .= '</tbody>';
        $salida .= '</table>';
        $salida .= '</div>'; // Cerrar el div table-responsive
        $salida .= '</div>'; // Cerrar el div container-fluid

        // Cerrar la conexión
        $conn->close();

        // Retornar la salida
        return $salida;
    }
    /**
     * Función para obtener y mostrar una tabla HTML con las inscripciones a cursos.
     * 
     * Esta función incluye la configuración de la base de datos, realiza una consulta
     * para obtener todas las inscripciones de la tabla 'inscripción' y genera una 
     * tabla HTML con los resultados. Además, incluye enlaces para editar y eliminar 
     * cada inscripción.
     * 
     * @return string Una cadena con la tabla HTML generada con los datos de las inscripciones.
     */
    public static function verinscripciones()
    {
        // Incluir la configuración de la base de datos
        include 'db_config.php';

        // Variable para almacenar la salida
        $salida = "";

        // Consulta SQL para seleccionar todos los cursos de la tabla 'inscripción'
        $sql = "SELECT inscripción_id, curso_id, usuario_id, nombre, correo, genero, pais, cursos_anteriores, nota, fecha_registro FROM inscripción";

        // Ejecución de la consulta
        $consulta = $conn->query($sql);

        // Verificar si la consulta fue exitosa
        if (!$consulta) {
            die("Error en la consulta: " . $conn->query($sql));
        }

        // Construcción de la tabla HTML con los datos de las inscripciones
        $salida = '<div class="container-fluid" style="max-width:400vh;">';
        $salida .= '<div class="table-responsive">';
        $salida .= '<table class="table table-striped table-hover table-bordered">';
        $salida .= '<thead class="table-dark">';
        $salida .= '<tr>';
        $salida .= '<th scope="col">Inscripción ID</th>';
        $salida .= '<th scope="col">Curso ID</th>';
        $salida .= '<th scope="col">Usuario ID</th>';
        $salida .= '<th scope="col">Nombre</th>';
        $salida .= '<th scope="col">Correo</th>';
        $salida .= '<th scope="col">Género</th>';
        $salida .= '<th scope="col">País</th>';
        $salida .= '<th scope="col">Cursos Anteriores</th>';
        $salida .= '<th scope="col">Nota</th>';
        $salida .= '<th scope="col">Fecha Registro</th>';
        $salida .= '<th scope="col">Eliminar</th>';
        $salida .= '</tr>';
        $salida .= '</thead>';
        $salida .= '<tbody>';

        while ($fila = $consulta->fetch_assoc()) {
            $inscripción_id = htmlspecialchars($fila['inscripción_id'], ENT_QUOTES, 'UTF-8');
            $curso_id = htmlspecialchars($fila['curso_id'], ENT_QUOTES, 'UTF-8');
            $usuario_id = htmlspecialchars($fila['usuario_id'], ENT_QUOTES, 'UTF-8');
            $nombre = htmlspecialchars($fila['nombre'], ENT_QUOTES, 'UTF-8');
            $correo = htmlspecialchars($fila['correo'], ENT_QUOTES, 'UTF-8');
            $genero = htmlspecialchars($fila['genero'], ENT_QUOTES, 'UTF-8');
            $pais = htmlspecialchars($fila['pais'], ENT_QUOTES, 'UTF-8');
            $cursos_anteriores = htmlspecialchars($fila['cursos_anteriores'], ENT_QUOTES, 'UTF-8');
            $nota = htmlspecialchars($fila['nota'], ENT_QUOTES, 'UTF-8');
            $fecha_registro = htmlspecialchars($fila['fecha_registro'], ENT_QUOTES, 'UTF-8');

            $salida .= '<tr>';
            $salida .= '<td>' . $inscripción_id . '</td>';
            $salida .= '<td>' . $curso_id . '</td>';
            $salida .= '<td>' . $usuario_id . '</td>';
            $salida .= '<td>' . $nombre . '</td>';
            $salida .= '<td>' . $correo . '</td>';
            $salida .= '<td>' . $genero . '</td>';
            $salida .= '<td>' . $pais . '</td>';
            $salida .= '<td>' . $cursos_anteriores . '</td>';
            $salida .= '<td>' . $nota . '</td>';
            $salida .= '<td>' . $fecha_registro . '</td>';
            $salida .= '<td><a href="../model/eliminar_curso.php?id=' . $inscripción_id . '" class="btn btn-danger btn-sm">Eliminar</a></td>';
            $salida .= '</tr>';
        }

        $salida .= '</tbody>';
        $salida .= '</table>';
        $salida .= '</div>'; // Cerrar el div table-responsive
        $salida .= '</div>'; // Cerrar el div container-fluid

        // Cerrar la conexión
        $conn->close();

        // Retornar la salida
        return $salida;
    }

}
?>