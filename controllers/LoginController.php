<?php  

namespace Controllers;


use Model\Usuario;
use Classes\Email;
use MVC\Router;

    class LoginController {
        public static function login( Router $router ) {
            $alertas = [];
            $auth = new Usuario;

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $auth = new Usuario($_POST);
                $alertas = $auth->validarLogin();
 
                if(empty($alertas)) {
                    // comprobar que exista el usuario
                    $usuario = Usuario::where('email', $auth->email);
                        if($usuario) {
                            // verificar pass
                            if($usuario->comprobarPasswordVerificado($auth->password)) {
                            // autenticar usuario
                            session_start();

                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                            $_SESSION['email'] = $usuario->email;
                            $_SESSION['login'] = true;
                            
                            // Redireccionamiento 

                            if($usuario->admin === "1") {
                                $_SESSION['admin'] = $usuario->admin ?? null;
                                header('Location: /admin');
                            } else {
                                header('Location: /cita');
                            }

                            }
                        } else {
                            Usuario::setAlerta('error', 'Usuario no econtrado');
                        }
                }
            }
            $alertas = Usuario::getAlertas();

            $router->render('auth/login', [
                'alertas' => $alertas,
                'auth' => $auth
            ]); 
    } 

        public static function logout() {
            session_start();
            $_SESSION = [];
            header('Location: /');
        }

        public static function olvide( Router $router ) {
            $alertas = [];
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $auth = new Usuario($_POST);
                $alertas = $auth->validarEmail();

                if(empty($alertas)) {
                    $usuario = Usuario::where('email', $auth->email);
                    if($usuario && $usuario->confirmado === "1") {
                        // generar un token de un solo uso  
                        $usuario->crearToken();
                        $usuario->guardar();

                        // enviar el email:
                        $email = new Email($usuario->email, $usuario->nombre, 
                                           $usuario->token);
                        $email->enviarInstrucciones();


                        // alerta de exito
                        Usuario::setAlerta('exito', 'Revisa tu email');

                    } else {
                        $usuario::setAlerta('error', 'El usuario no existe o no confirmo');
                    }
                }
            }
            $alertas = Usuario::getAlertas();

            $router->render('auth/olvide', [
                'alertas' => $alertas 
            ]);
        }

        public static function recuperar(Router $router) {
            $alertas = [];
            $error = false;

            $token = sanit($_GET['token']);

            //buscar usuario por su token
            $usuario = Usuario::where('token', $token);
            if(empty($usuario)) {
                Usuario::setAlerta('error', 'Token no valido');
                $error = true;
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                // leer el siguiente pasw y guardarlo

                $password = new Usuario($_POST);
                $alertas = $password->validarPassword();

                if(empty($alertas)) {
                    $usuario->password = null;
                    $usuario->password = $password->password;
                    $usuario->hashPassword();
                    $usuario->token = null;

                    $resultado = $usuario->guardar();
                    if($resultado) {
                        header('Location: /');
                    }
                }
            }

            $alertas = Usuario::getAlertas();
            $router->render('auth/recuperar-password', [
                'alertas' => $alertas,
                'error' => $error
            ]);
        }

        public static function crear( Router $router ) {
            $usuario = new Usuario;

            // Alertas vacias
            $alertas = [];
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $usuario->sincronizar($_POST);
                $alertas = $usuario->validarNuevaCuenta();

            // revisar que alertas este vacio
            if(empty($alertas)) {
                $resultado = $usuario->existeUsuario();
                    if($resultado->num_rows) {
                        $alertas = Usuario::getAlertas();
                    } else {
                        // hashear el password
                        $usuario->hashPassword();

                        // generar un token unico
                        $usuario->crearToken();

                        // enviar email
                        $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                        $email->enviarConfirmacion();

                        // crear el usuario
                        $resultado = $usuario->guardar();
                        if($resultado) {
                            header('Location: /mensaje');
                        }                      
                    }
                }
            }   

            $router->render('auth/crear-cuenta', [
                'usuario' => $usuario,
                'alertas' => $alertas

            ]);
        }

        public static function mensaje( Router $router ) {

            $router->render('auth/mensaje');
        }    

        public static function confirmar ( Router $router ) {
            $alertas = [];
            $token = sanit($_GET['token']);    
            
            $usuario = Usuario::where('token', $token);

            if(empty($usuario)) {
                $usuario::setAlerta('error', 'Token no valido');       // mostrar el error     
            } else {
                // modificar usuario confirmado
                $usuario->confirmado = "1";
                $usuario->token = null; 
                $usuario->guardar();
                Usuario::setAlerta('exito', 'Cuenta Comprobada');
            }

            $alertas = Usuario::getAlertas();
            $router->render('auth/confirmar-cuenta', [
                'alertas' => $alertas

            ]);
        }
    }