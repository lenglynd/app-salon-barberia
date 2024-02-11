<?php 
namespace Controllers;

use Models\Cita;
use Models\CitaServicios;
use Models\Servicio;

class APIController{

    public static function index() {
        
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }
    
    public static function guardar() {
        
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        
        $id = $resultado['id'];
        $idServicios = explode(",",$_POST['servicios']);
        
        foreach ($idServicios as $idServicio) {
            $args = [
                'citaid' => $id,
                'servicioid' =>  $idServicio
            ];
          
            $citaServicio = new CitaServicios($args);
            $citaServicio->guardar();
        }
        
        
        
        echo json_encode(['resultado' => $resultado]);
    }
    public static function eliminar() {
        if ($_SERVER['REQUEST_METHOD']==='POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->eliminar();
            header('Location:'.$_SERVER['HTTP_REFERER']);
        }
        
    }
}


?>