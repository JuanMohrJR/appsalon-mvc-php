<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email; 
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) {

        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    
    public function enviarConfirmacion() {

        // crear el objeto de email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PSW'];
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon'); 
        $mail->Subject = 'Confirma tu cuenta';

        // Set HTML 
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p> <strong> Hola " . $this->nombre . "</strong> Has creado tu ceunta en Appsalon,
        solo debes confirmarla ingresando en el siguiente enlace </p>";
        $contenido .= "<p> Presione aqui: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'> Confirmar Cuenta </a> </p>";
        $contenido .= "<p> Si tu no solicitaste este cambio, ignora este mensaje. </p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar el Email
        try {
            $resultado = $mail->send();

            if($resultado == false){
                echo $mail->ErrorInfo;
                die();
            }
        } catch (\Throwable $th) {
            var_dump($th);
        }    
    }

    public function enviarInstrucciones() {
        // crear el objeto de email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PSW'];
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon'); 
        $mail->Subject = 'Restablece tu PSW';

        // Set HTML 
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p> <strong> Hola " . $this->nombre . "</strong> Has 
        solicitado restablecer tu password, confirmalo en el siguiente enlace </p>";
        $contenido .= "<p> Presione aqui: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=" . $this->token . "'> Restablece tu PSW </a> </p>";
        $contenido .= "<p> Si tu no solicitaste este cambio, ignora este mensaje. </p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar el Email
        try {
            $resultado = $mail->send();

            if($resultado == false){
                echo $mail->ErrorInfo;
                die();
            }
        } catch (\Throwable $th) {
            var_dump($th);
        }    
    }



}