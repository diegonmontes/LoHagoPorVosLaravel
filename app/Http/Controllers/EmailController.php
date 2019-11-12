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
    
    // Recibe por parametro el obj usuario del asignado (para obtener su mail)
    // Obj persona asignado para obtener datos de el
    // Obj trabajo para obtener datos de ello
    // Obj persona creador del anuncio
    // En esta funcion envia un mail al asignado indicandole que debe realizar el anuncio
    public function enviarMailConfirmacionAsignado($objUsuarioAsignado,$objPersonaAsignado,$objTrabajo,$objPersonaCreador){
        
        $dato = [
                    'nombrePersonaAsignada' => $objPersonaAsignado->nombrePersona,
                    'apellidoPersonaAsignada' => $objPersonaAsignado->apellidoPersona,
                    'tituloTrabajo' => $objTrabajo->titulo,
                    'descripcionTrabajo' => $objTrabajo->descripcion,
                    'montoTrabajo' => $objTrabajo->monto,
                    'nombrePersonaCreador' => $objPersonaCreador->nombrePersona,
                    'apellidoPersonaCreador' => $objPersonaCreador->apellidoPersona
                ];
                

        $subject = "Se te ha asignado un anuncio";
        $for = "$objUsuarioAsignado->mailUsuario";
        Mail::send('email/mailconfirmacionasignado',$dato, function($msj) use($subject,$for){

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

    // Mail que se envia despues de que el asignado pone 'finalice mi trabajo' Es decir, pasa al estado 4
    // Mail que se envia al anunciante para que confirme que el trabajo se hizo correctamente
    public function enviarMailConfirmarTrabajo($objUsuarioAsignado,$objPersonaAsignado,$objTrabajo,$objPersonaCreador){

        $dato = [
            'nombrePersonaAsignada' => $objPersonaAsignado->nombrePersona,
            'apellidoPersonaAsignada' => $objPersonaAsignado->apellidoPersona,
            'tituloTrabajo' => $objTrabajo->titulo,
            'descripcionTrabajo' => $objTrabajo->descripcion,
            'idTrabajo'=>$objTrabajo->idTrabajo,
            'montoTrabajo' => $objTrabajo->monto,
            'nombrePersonaCreador' => $objPersonaCreador->nombrePersona,
            'apellidoPersonaCreador' => $objPersonaCreador->apellidoPersona
        ];

       
        $subject = "Confirmar que se ha hecho el anuncio";
        $for = "$objUsuarioAsignado->mailUsuario";
        Mail::send('email/confirmaranuncioterminado',$dato, function($msj) use($subject,$for){
            $msj->from('lohagoporvosservicios@gmail.com',"Lo hago por vos");
            $msj->subject($subject);
            $msj->to($for);
        });

        return redirect()->route('home');

    }
        
    // Mail que se envia al cuando el anunciante confirma que se realizo el trabajo correctamente. Estado 5
    public function enviarMailFinalizado($objUsuarioAsignado,$objPersonaAsignado,$objTrabajo,$objPersonaCreador){

        $dato = [
            'nombrePersonaAsignada' => $objPersonaAsignado->nombrePersona,
            'apellidoPersonaAsignada' => $objPersonaAsignado->apellidoPersona,
            'tituloTrabajo' => $objTrabajo->titulo,
            'descripcionTrabajo' => $objTrabajo->descripcion,
            'nombrePersonaCreador' => $objPersonaCreador->nombrePersona,
            'apellidoPersonaCreador' => $objPersonaCreador->apellidoPersona
        ];
        
        $subject = "Anuncio finalizado correctamente";
        $for = "$objUsuarioAsignado->mailUsuario";
        Mail::send('email/anunciofinalizado',$dato, function($msj) use($subject,$for){
            $msj->from('lohagoporvosservicios@gmail.com',"Lo hago por vos");
            $msj->subject($subject);
            $msj->to($for);
        });

        return redirect()->route('home');


    }
}
