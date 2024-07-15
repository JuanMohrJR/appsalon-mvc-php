<?php   namespace Controllers;

use MVC\Router;
use Model\AdminCita;


class AdminController{
    public static function index( Router $router ) {
        session_start();

        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);

        if( !checkdate( $fechas[1], $fechas[2], $fechas[0]) ) {
            header('Location: /404');
        }

        // consultar la base de datos

    $consulta = "SELECT citas.id, citas.hora, "; 
    $consulta .= " CONCAT(usuarios.nombre,' ',usuarios.apellido) as Cliente, ";
    $consulta .= " usuarios.email, usuarios.telefono, ";
    $consulta .= " servicios.nombre as Servicio, servicios.precio ";
    $consulta .= " FROM citas ";
    $consulta .= " LEFT OUTER JOIN usuarios ";
    $consulta .= " ON citas.usuariosid=usuarios.id ";
    $consulta .= " LEFT OUTER JOIN citasservicios ";
    $consulta .= " ON citasservicios.citaid=citas.id ";
    $consulta .= " LEFT OUTER JOIN servicios ";
    $consulta .= " ON servicios.id=citasservicios.servicioid ";
    $consulta .= " WHERE fecha = '{$fecha}' ";

        $citas = AdminCita::SQL($consulta);


        $router->render('admin/index',[
            'citas' => $citas,
            'fecha' => $fecha
        ]);

    }
}

