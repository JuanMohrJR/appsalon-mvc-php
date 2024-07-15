<h1 class="nombre-pagina"> Desde servicios index </h1>
<p class="descripcion-pagina"> Admin de servicios </p>

<?php
    include_once __DIR__ . '/../templates/barra.php';
?>  


<div class="campo">
    <label for="nombre">Nombre</label>
    <input type="text" id="nombre" placeholder="Nombre servicio" name="nombre"
    value="<?php print ($servicio->nombre); ?>">

</div>

<div class="campo">
    <label for="precio">Precio</label>
    <input type="number" id="precio" placeholder="Precio servicio" name="precio"
    value="<?php print ($servicio->precio); ?>">

</div>