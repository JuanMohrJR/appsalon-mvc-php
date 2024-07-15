<h1 class="nombre-pagina"> Desde servicios index </h1>
<p class="descripcion-pagina"> Admin de servicios </p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
?>  

<ul class="servicios">
    <?php foreach($servicios as $servicio) { ?>
        <li>
            <p>Nombre: <span> <?php print $servicio->nombre; ?> </span></p>
            <p>Precio: <span> $ <?php print  $servicio->precio; ?> </span></p>

            <div class="acciones">

                <a class="boton boton-actualizar" href="servicios/actualizar?id=<?php print $servicio->id; ?>">Actualizar</a>
            
                <form action="/servicios/eliminar" method="POST">
                <input type="hidden" name="id" value="<?php print $servicio->id; ?>">
                <input type="submit" value="Borar" class="boton-eliminar">
                
                </form>
            
            </div>
        </li>

    <?php } ?>
</ul>