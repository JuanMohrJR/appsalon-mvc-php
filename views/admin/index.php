
<?php 
    include_once __DIR__ . '/../templates/barra.php';
?>


<h1 class="nombre-pagina"> Panel de administracion</h1>


<p>Buscar citas</p>
<div class="busqueda">
 <form action="" class="formulario">
    <div class="campo">
        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" value="<?php print $fecha; ?>">
    </div>
 </form>
</div>

<?php
    if(count($citas) === 0 ) { ?>
    <h2 class="h2fecha"> No hay citas en la fecha seleccionada</h2>
   <?php } ?>

<div id="citas-admin"> 
    <ul class="citas">
    <?php
        $idCita = 0;
        foreach($citas as $key => $cita) {

            if($idCita !== $cita->id) {       
                $total = 0;   
    ?>
    <li>
            <p>ID: <span><?php print $cita->id; ?></span></p>
            <p>Hora: <span><?php print $cita->hora; ?></span></p>
            <p>Cliente: <span><?php print $cita->Cliente; ?></span></p>
            <p>Email: <span><?php print $cita->email; ?></span></p>

            <h3>Servicios:</h3>
    <?php 
        $idCita = $cita->id;
        } // Fin del if 
        $total += $cita->precio;
        ?>
        <p class="servicio"><?php print $cita->Servicio . " " . $cita->precio; ?></p>
    <?php
        $actual = $cita->id;
        $proximo = $citas[$key + 1]->id ?? 0;

        if(last($actual, $proximo)) { ?>
            <p class="total">Total: <span>$<?php print $total; ?></span"></p>


            <form action="/api/eliminar" method="POST">
                <input type="hidden" name="id" value="<?php print $cita->id; ?>">
                <input type="submit" class="boton-eliminar" value="Eliminar">
            </form>
        <?php }
    } // Fin del foreach  
    ?>
    </ul>
</div>

<?php 
    $script = "
    <script src='build/js/buscador.js'></script>
    ";
?>