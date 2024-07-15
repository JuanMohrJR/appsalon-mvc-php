

<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form action="/" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu Email" name="email"
        value=" <?php print sanit($auth->email); ?> ">
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Password" name="password">
       
    </div>
    <input type="submit" class="boton" value="Iniciar Sesion"> 

</form>



<div class="acciones">
    <a href="/crear-cuenta">Crear una cuenta nueva</a>
    <a href="/olvide">Recuperar Password</a>
</div>