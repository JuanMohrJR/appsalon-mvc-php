<h1 class="nombre-pagina">Recuperar Password</h1>

<p class="descripcion-pagina">Ingrese su E-mail para recuperar su password</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>



<form action="/olvide" class="formulario" method="POST">

<div class="campo">
    <label for="email">E-mail:</label>
    <input type="email" id="email" placeholder="Tu correo electronico" name="email">
</div>

    <input type="submit" class="boton olvide" value="Recuperar">

</form>

<div class="acciones">
    <a href="/crear-cuenta">Crear una cuenta nueva</a>
    <a href="/">Si tienes una cuenta, Inicia sesion</a>
</div>