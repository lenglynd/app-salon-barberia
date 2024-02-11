<?php 
namespace Controllers;

use Classes\Email;
use Models\Usuarios;
use MVC\Router;

class LoginController{
    public static function login(Router $router) {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $auth = new Usuarios($_POST);
            $alertas= $auth->validarLogin();
            
            if (empty($alertas)) {
                $usuario = Usuarios::where('email', $auth->email);
                if ($usuario) {
                   if ($usuario->comprobarAndVerificado($auth->password)){
                        session_start();
                        $_SESSION['id']= $usuario->id;
                        $_SESSION['nombre']= $usuario->nombre." ".$usuario->apellido;
                        $_SESSION['email']= $usuario->email;
                        $_SESSION['login']= true;

                        if ($usuario->admin === "1") {
                            $_SESSION['admin']= $usuario->admin ?? null;
                            header('Location:/admin');

                        }else {
                            header('Location:/cita');
                        }
                   }
                }else {
                    Usuarios::setAlerta('error','usuario no encontrado o registrado');
                }
                
            }
        }
        $alertas=Usuarios::getAlertas();

        $router->render('auth/login',[
            'alertas' => $alertas
        ]);


    }
    public static function logout() {
        session_start();
        $_SESSION = [];


        header('Location:/');
    }
    public static function olvide(Router $router) {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $auth = new Usuarios($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuarios::where('email',$auth->email);
                if ($usuario && $usuario->confirmado === '1') {
                    $usuario->crearToken();
                    $usuario->guardar();
                    $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarInstrucciones();

                    Usuarios::setAlerta('exito','Enviamos las instrucciones a tu correo registrado');
                    
                }else {
                    Usuarios::setAlerta('error','El usuario no existe o no esta confirmado');
                }
            }
            
        }
        $alertas = Usuarios::getAlertas();

        $router->render('auth/olvide-password',[
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router) {
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);
        
            $usuario = Usuarios::where('token',$token);

            if (empty($usuario)) {
                Usuarios::setAlerta('error','El token no es valido');
                $error = true;
            } 
            if ($_SERVER['REQUEST_METHOD']==='POST') {
                $password = new Usuarios($_POST);
                $alertas = $password->validarPassword();
                if (empty($alertas)) {
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if ($resultado) {
                    header('Location:/');
                }
                }
            }
        
        
        $alertas= Usuarios::getAlertas();
        $router->render('auth/recuperar-password',[
            'alertas' => $alertas,
            'error' => $error,
        ]);
    }
    public static function crear(Router $router) {
        
            $usuario = new Usuarios();

            $alertas = [];
        
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            if (empty($alertas)) {
                $resultado=$usuario->existeUsuario();
                if ($resultado->num_rows) {
                    $alertas = Usuarios::getAlertas();
                }else {
                    //hashear el password
                    $usuario->hashPassword();
                    //generear token
                    $usuario->crearToken();
                    //enviar el token al email
                    $email = new Email($usuario->email,$usuario->nombre,$usuario->token);
                    $email->enviarMail();

                    //registrar ususario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                       header('Location:/mensaje');
                    }
                }
            }

        }

        $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function mensaje(Router $router) {
        

        $router->render('auth/mensaje');


    }
    public static function confirmar(Router $router) {

        $alertas = [];

        $token = s($_GET['token']);
        
        $usuario = Usuarios::where('token',$token);

        if (empty($usuario)) {
            Usuarios::setAlerta('error','El token no es valido');
        } else {
            
            $usuario->confirmado = '1';
            $usuario->token = null;
            $usuario->guardar();
            Usuarios::setAlerta('exito','La cuenta ha sido confirmada');
        }
        
            $alertas= Usuarios::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);


    }
}

?>