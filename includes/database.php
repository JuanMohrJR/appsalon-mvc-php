<?php

$bd = mysqli_connect(
    $_ENV['BD_HOST'], 
    $_ENV['BD_USER'], 
    $_ENV['BD_PSW'], 
    $_ENV['BD_NAME'] 
);

$bd->set_charset('utf8'); 

if (!$bd) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
