<div class="container bg-dark text-light p-4 rounded" style="max-width: 45%;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h2 class="text-center">Recupera contraseña</h2>
            <p class="text-center">Ingresa el nombre de usuario y correo de usuario</p>
            <form action="../controller/verificar.php" method="get">
                <div class="form-group">
                    <label for="nombre">Nombre de usuario</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required>
                </div>
                <div class="form-group">
                    <label for="correo">Correo de usuario</label>
                    <input type="email" class="form-control" name="correo" id="correo" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3" style="width: 100%;">Enviar</button>
            </form>
        </div>
    </div>
</div>
