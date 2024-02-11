<h1 class="nombre-pagina">Restablece tu Cuenta</h1>
<p class="descripcion-pagina">Coloca la nueva clave ha restablecer</p>

<?php include_once __DIR__.'/../templates/alertas.php'; ?>
<?php if ($error) return?>

<form  method="POST" class="formulario">
    
    
    <div class="campo">
        <label for="password">Password</label>
        <input 
            type="password"
            name="password" 
            id="password" 
            placeholder="Tu Password"
        />
    </div>


    <input type="submit" value="Restablecer Cuenta" class="boton">
    
</form>
<div class="acciones">
    <a class="boton" href="/">Iniciar sesión</a>
    <a class="boton" href="/crear-cuenta">Crea una cuenta</a>
</div>