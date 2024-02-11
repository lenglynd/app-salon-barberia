<h1 class="nombre-pagina">Crea un nuevo servicio</h1>
<p class="descripcion-pagina">Creación de servicios</p>

<?php 
    include_once __DIR__.'/../templates/barra.php';
    include_once __DIR__.'/../templates/alertas.php';
?>

<form action="/servicios/crear" class="formulario" method="POST">

    <?php include_once __DIR__.'/formulario.php'; ?>
    <input class="boton" type="submit" value="Guardar Servicio">
</form>