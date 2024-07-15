<h1 class="nombre-pagina">Recuperar Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo Password con al menos 8 caracteres</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";


    if($error) return;
?>



<form class="formulario" method="POST">
    <div class="campo"> 
        <label for="password"> Password </label>
        <input type="password" id="password" name="password" placeholder="Tu Nuevo PSW">
    </div>
    <input type="submit" class="boton" value="Guardar Nuevo Password">
</form>

<div class="acciones">
    <a href="/">Si tienes cuenta, inicia sesion</a>
    <a href="/crear-cuenta"> No tienes cuenta? Obtener una. </a>
</div>
