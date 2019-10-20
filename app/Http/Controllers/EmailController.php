<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail; //Importante incluir la clase Mail, que será la encargada del envío

class EmailController extends Controller
{
  
    public function contact(Request $request){
        $subject = "Asunto del correo";
        $for = "alejandrowasilewski@gmail.com";
        Mail::send('email',$request->all(), function($msj) use($subject,$for){
            $msj->from("tucorreo@gmail.com","NombreQueApareceráComoEmisor");
            $msj->subject($subject);
            $msj->to($for);
        });
        return redirect()->back();
    }

    public function validarmail($usuario){
        $dato = ['mailUsuario' => $usuario->mailUsuario];
        $subject = "Bienvenido a Lo hago por vos";
        $for = "$usuario->mailUsuario";
        Mail::send('email/validarmail',$dato, function($msj) use($subject,$for){
            $msj->from('lohagoporvosservicios@gmail.com',"Lo hago por vos");
            $msj->subject($subject);
            $msj->to($for);
        });
        
        return redirect()->route('login');
    }
}
