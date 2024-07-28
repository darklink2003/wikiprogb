<div class="container dark mt-5" style="background-color:black; border-radius:15px; padding:10px;">
    <form action="../controller/verificar.php" method="get">
        <div class="form-group">
            <label for="nombre">Nombre de usuario</label>
            <input type="text" class="form-control" name="nombre" id="nombre">
        </div>
        <div class="form-group">
            <label for="correo">Correo de usuario</label>
            <input type="email" class="form-control" name="correo" id="correo">
        </div><br>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>