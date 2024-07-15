<?php

    function debuguear($variable) : string {
        echo "<pre>";
        var_dump($variable);
        echo "</pre>";
        exit;
    }

    // Escapa / Sanitizar el HTML
    function sanit($html) : string {
        $s = htmlspecialchars($html);
        return $s;
    }

    function last(string $actual, string $proximo): bool {
        if($actual !== $proximo) {
            return true;
        } else { return false; }
    }

    // funcion paraa autentificar el usuario
    function userAuth() : void {
        if(!isset($_SESSION['login'])) {
            header('Location: /');
        }
    }

    function isAdmin() : void {
        if(!isset($_SESSION['admin'])) {
            header('Location: /');
        }
    }

    