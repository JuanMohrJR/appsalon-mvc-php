

<?php 

    foreach($alertas as $key => $mensajes):
        foreach($mensajes as $mensaje):
?>  
    <div class="alerta <?php print $key; ?>">
            <?php print $mensaje; ?>

    </div>


<?php
        endforeach;
    endforeach;
    
?>