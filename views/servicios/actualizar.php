<h1 class="nombre-pagina">Actualizar</h1>
<p class="descripcion-pagina">Modifica los servicios</p>

<?php 
    include_once __DIR__.'/../templates/barra.php';
    include_once __DIR__.'/../templates/alertas.php';
?>
<form  class="formulario" method="POST">

<?php include_once __DIR__.'/formulario.php'; ?>
<input class="boton" type="submit" value="Actualizar Servicio">
</form>