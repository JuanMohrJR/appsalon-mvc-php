<div class="barra">
    <p>Bienvenido: <span> <?php print $_SESSION['nombre']; ?> </span></p>
    <a href="/logout" class="boton">Cerrar sesion</a>
</div>


<?php 
    if(isset($_SESSION['admin'])) { ?>
        <div class="barra-servicio">
            <a class="boton" href="/admin">Ver Citas</a>
            <a class="boton" href="/servicios">Ver Servicios</a>
            <a class="boton" href="/servicios/crear">Nuevo Servicio</a>
        </div>

    
    
    
<?php    } else {
        
     } ?>