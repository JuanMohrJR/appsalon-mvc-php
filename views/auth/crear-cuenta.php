<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Completa el siguiente formulario para crear una cuenta</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" action="/crear-cuenta" method="POST">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" placeholder="Tu nombre" name="nombre"
        value="<?php print sanit($usuario->nombre); ?>">
    </div>

    <div class="campo">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" placeholder="Tu Apellido" name="apellido"
        value="<?php print sanit($usuario->apellido); ?>">
    </div>

    <div class="campo">
        <label for="telefono">Celular:</label>
        <input type="tel" id="telefono" placeholder="Tu numero de celular" name="telefono"
        value="<?php print sanit($usuario->telefono); ?>">
    </div>

    <div class="campo">
        <label for="email">E-mail:</label>
        <input type="email" id="email" placeholder="Tu correo electronico" name="email"
        value="<?php print sanit($usuario->email); ?>">
    </div>


    <p class="pass">El password debe tener minimo 8 caracteres</p>

    <div class="campo">
        <label for="password">Password:</label>
        <input type="password" id="password" placeholder="Tu password" name="password">
    </div>

    <div class="campo">
        <label for="rePassword">Password:</label>
        <input type="password" id="rePassword" placeholder="Repite tu password" name="rePassword">
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">
    
</form>

<div class="acciones">
    <a href="/">Si ya tienen una cuenta, inicia secion</a>
    <a href="/olvide">Recuperar Password</a>
</div>