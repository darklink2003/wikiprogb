<!DOCTYPE html>
<html>
<head>
    <title>Instalador de Base de Datos</title>
</head>
<body>
    <h1>Configuración de la Base de Datos</h1>
    <form action="instalando.php" method="post">
        <label for="host">Host:</label>
        <input type="text" id="host" name="host" value="127.0.0.1" required><br><br>
        <label for="db_name">Nombre de la Base de Datos:</label>
        <input type="text" id="db_name" name="db_name" value="wikiprog" required><br><br>
        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" value="root" required><br><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Instalar">
    </form>
</body>
</html>
