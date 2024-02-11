<h1 class="nombre-pagina">Olvidé Clave</h1>
<p class="descripcion-pagina">Reestablece tu clave escribiendo tu email abajo</p>
<?php include_once __DIR__.'/../templates/alertas.php' ?>
<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
    <label for="email">Email</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu Email"
            />
    </div>
    <input type="submit" value="Recuperar" class="boton">
</form>
<div class="acciones">
    <a href="/">Iniciar sesión, si ya tienes cuenta</a>
    <a href="/crear-cuenta">Crea una nueva cuenta</a>
</div>