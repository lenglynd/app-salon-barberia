<?php 
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    
    public $email;
    public $nombre;
    public $token;
    public function __construct($email,$nombre,$token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    
    public function enviarMail() {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'tls';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress($this->email,'AppSalon.com');
        $mail->Subject = 'Confirma tu Cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido ="<html>";
        $contenido .="<p>Hola <strong> ".$this->nombre."</strong> Has creado un cuenta en App Salon, sólo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .="<p>Presiona aqui <a href='".$_ENV['APP_URL']."/confirmar-cuenta?token=".$this->token."'>Confirmar Cuenta</a></p>";
        $contenido .="<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .="</html>";

        $mail->Body = $contenido;
        //enviar el email
      
        $mail->send();

    }
    
    public function enviarInstrucciones() {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'tls';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress($this->email,'AppSalon.com');
        $mail->Subject = 'Confirma tu Cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido ="<html>";
        $contenido .="<p>Hola <strong> ".$this->nombre."</strong> Has solicitado restablecer tu cuenta en App Salon, sólo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .="<p>Presiona aqui <a href='".$_ENV['APP_URL']."/recuperar?token=".$this->token."'>Restablecar Cuenta</a></p>";
        $contenido .="<p>Si tu no solicitaste restablecer esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .="</html>";

        $mail->Body = $contenido;
        //enviar el email

        $mail->send();

    }
}


?>