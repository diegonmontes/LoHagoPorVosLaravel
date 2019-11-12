<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail; //Importante incluir la clase Mail, que será la encargada del envío

class EmailController extends Controller
{
  
    public function contact(Request $request){
        $subject = "Asunto del correo";
        $for = "example@gmail.com";
        Mail::send('email',$request->all(), function($msj) use($subject,$for){
            $msj->from("tucorreo@gmail.com","NombreQueApareceráComoEmisor");
            $msj->subject($subject);
            $msj->to($for);
        });
        return redirect()->back();
    }

    /**
     * Funcion que envia el mail para autenticar el correo electronico
     * object $usuario 
     */
    public function validarmail($usuario){
        //Creamos un arreglo para enviar los datos que necesitamos a la vista del mail
        $dato = [
                    'mailUsuario' => $usuario->mailUsuario,
                    'nombreUsuario' => $usuario->nombreUsuario,
                    'auth_key' => $usuario->auth_key,
                    'id' => $usuario->idUsuario
                ];
        $subject = "Bienvenido a Lo hago por vos";
        $for = "$usuario->mailUsuario";
        Mail::send('email/validarmail',$dato, function($msj) use($subject,$for){
            $msj->from('lohagoporvosservicios@gmail.com',"Lo hago por vos");
            $msj->subject($subject);
            $msj->to($for);
        });
        
        return redirect()->route('home');
    }

    public function nuevoMail($usuario){
        //Creamos un arreglo para enviar los datos que necesitamos a la vista del mail
        $dato = [
                    'mailUsuario' => $usuario->mailUsuario,
                    'nombreUsuario' => $usuario->nombreUsuario,
                    'auth_key' => $usuario->auth_key,
                    'id' => $usuario->idUsuario
                ];
        $subject = "Actualizacion de mail";
        $for = "$usuario->mailUsuario";
        Mail::send('email/nuevoMail',$dato, function($msj) use($subject,$for){
            $msj->from('lohagoporvosservicios@gmail.com',"Lo hago por vos");
            $msj->subject($subject);
            $msj->to($for);
        });
        
        return redirect()->route('home');
    }

    
}
