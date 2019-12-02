<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Multa;
use App\Estadotrabajo;
use App\Trabajo;
use App\Persona;
use App\User;
use App\ConversacionChat;
use Auth;
use App\Http\Controllers\TrabajoasignadoController;
use App\Http\Controllers\TrabajoaspiranteController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MontoController;
use App\Http\Controllers\EmailController;


class MultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexpanel()
    {
        $multas=Multa::orderBy('idMulta','DESC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('multa.indexpanel',compact('multas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createpanel()
    {
        $arregloBuscarTrabajos=['eliminado'=>0];
        $arregloBuscarTrabajos = new Request($arregloBuscarTrabajos);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaTrabajos = json_decode($listaTrabajos);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);
        return view('multa.createpanel',['listaTrabajos'=>$listaTrabajos,'listaPersonas'=>$listaPersonas]); //Vista para crear el elemento nuevo
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function storepanel(Request $request)
    {
        $mensajesErrores =[             
            'motivo.required' => 'El motivo es obligatorio.',
            'motivo.max' => 'Maximo de letras sobrepasado.',
            'valor.required' => 'El valor es obligatorio.',
            'valor.numeric' => 'Solamente se puede ingresar numeros.',
            'idPersona.required'=> 'La persona es obligatoria',
            'idTrabajo.required'=> 'El trabajo es obligatorio',
            
        ] ;

        $this->validate($request,['idPersona'=>'required','motivo'=>'required|max:255','valor'=>'required|numeric','idTrabajo'=>'required'],$mensajesErrores);
            
        if (Multa::create($request->all())){
            return redirect()->route('multa.indexpanel')->with('success','Registro creado satisfactoriamente');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $multas=Multa::find($id); //Buscamos el elemento para mostrarlo
        return  view('multa.show',compact('multas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $arregloBuscarTrabajos=['eliminado'=>0];
        $arregloBuscarTrabajos = new Request($arregloBuscarTrabajos);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaTrabajos = json_decode($listaTrabajos);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);
        $multa=Multa::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('multa.edit',compact('multa'),['listaTrabajos'=>$listaTrabajos,'listaPersonas'=>$listaPersonas]);
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mensajesErrores =[             
            'motivo.required' => 'El motivo es obligatorio.',
            'motivo.max' => 'Maximo de letras sobrepasado.',
            'valor.required' => 'El valor es obligatorio.',
            'valor.numeric' => 'Solamente se puede ingresar numeros.',
            'idPersona.required'=> 'La persona es obligatoria',
            'idTrabajo.required'=> 'El trabajo es obligatorio',
            
        ] ;
        $this->validate($request,['idPersona'=>'required','motivo'=>'required|max:255','valor'=>'required|numeric','idTrabajo'=>'required'],$mensajesErrores);
        

        Multa::find($id)->update($request->all()); // Si actualiza la multa , obtenemos su id para llenar el resto de las tablas
        return redirect()->route('multa.indexpanel')->with('success','Registro actualizado satisfactoriamente');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Actualizamos eliminado a 1 (Borrado lógico)
        Multa::where('idMulta',$id)->update(['eliminado'=>1]);
        //Multa::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('multa.indexpanel')->with('success','Registro eliminado satisfactoriamente');
    }

    public function cancelartrabajo(request $request){
        
        $idTrabajo = $request->idTrabajo;
        $motivo = $request->motivo;
        $conversacionChatController = new ConversacionChatController();
        $valor = 300;

        if (isset($request->idPersona)){ // Si esta seteado significa que viene desde flutter o esta cancelando el que esta asignado
            $idPersona = $request->idPersona;
        } else { // Significa que esta en laravel y esta cancelando el creador
            $idUsuario = Auth::user()->idUsuario;
            $persona = Persona::where('idUsuario','=',$idUsuario)->get();
            $idPersona=$persona[0]->idPersona;
        }

        try {
            Trabajo::find($idTrabajo)->update(['idEstado'=>6]);

            // Creamos el registro nuevo en estadotrabajo
            $paramEstadotrabajo = ['idTrabajo'=>$idTrabajo,'idEstado'=>6];
            $requestEstadoTrabajo = new Request($paramEstadotrabajo);
            Estadotrabajo::create($requestEstadoTrabajo->all());

            // Obtenemos el id de la conversacion para deshabilitarlo
            $arregloConversacion = ['idTrabajo'=>$idTrabajo];
            $requestArregloConversacion = new Request($arregloConversacion);
            $listaConversaciones = $conversacionChatController->buscar($requestArregloConversacion);
            $listaConversaciones = json_decode($listaConversaciones);
            $objConversacion = $listaConversaciones[0];
            $idConversacion = $objConversacion->idConversacionChat;

            ConversacionChat::find($idConversacion)->update(['deshabilitado'=>true]);
            $paramMulta = ['idTrabajo'=>$idTrabajo,'idPersona'=>$idPersona,'motivo'=>$motivo,'valor'=>$valor];
            if (Multa::create($paramMulta)){
                $multaCreada = true;
            } else {
                $multaCreada = false;
            }
    
        } catch (Exception $e){

        }

        if ($multaCreada){ // Es decir esta todo bien yy ahora envia los mails
            $arregloIdTrabajo = ['idTrabajo'=>$idTrabajo];
            $requestIdTrabajo = new Request($arregloIdTrabajo);

            $this->enviarMailCanceladoAsignado($requestIdTrabajo);
            $this->enviarMailCreadorCancelado($requestIdTrabajo);
            $respuesta = true;
        } else {
            $respuesta = false;
        }

        return $respuesta;
    }

    // Recibimos por parametro el id trabajo. Enviamos a la funcion del email controller el obj trabajo, obj persona creador de este, objpersona y objusuario del asignado 
    // Aca llama a la funcion que va a enviar el mail que le envia al asignado cuando el creador cancela su anuncio
    public function enviarMailCanceladoAsignado(request $request){

        // Hacemos la creacion de los objs controladores
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $usuarioController = new UserController();
        $trabajoAsignadoController = new TrabajoasignadoController();
        $multaController = new MultaController();
        
        $idTrabajo = $request->idTrabajo; // Obtenemos el id del trabajo para buscar el trabajo 

        // Obtenemos el trabajo que se asigno
        $arregloBuscarTrabajo = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajo = new Request($arregloBuscarTrabajo);
        $listaTrabajo = $trabajoController->buscar($arregloBuscarTrabajo);
        $listaTrabajo = json_decode($listaTrabajo);
        $objTrabajo = $listaTrabajo[0];

        // Obtenemos el idPersona del creador del trabajo

        $idPersonaCreador = $objTrabajo->idPersona;
        $arregloBuscarPersonaCreador = ['idPersona'=>$idPersonaCreador];
        $arregloBuscarPersonaCreador = new Request($arregloBuscarPersonaCreador);
        $listaPersonaCreador = $personaController->buscar($arregloBuscarPersonaCreador);
        $listaPersonaCreador = json_decode($listaPersonaCreador);
        $objPersonaCreador = $listaPersonaCreador[0];

        // Buscamos el trabajo asignado
        $arregloBuscarTrabajoAsignado = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajoAsignado = new Request($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = $trabajoAsignadoController->buscar($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = json_decode($listaTrabajoAsignado);
        $objTrabajoAsignado = $listaTrabajoAsignado[0]; // Obtenemos el trabajo asignado

        // Obtenemos el idPersona de la persona asignada del trabajo

        $idPersonaAsignado = $objTrabajoAsignado->idPersona;
        $arregloBuscarPersonaAsignada = ['idPersona'=>$idPersonaAsignado];
        $arregloBuscarPersonaAsignada = new Request($arregloBuscarPersonaAsignada);
        $listaPersonaAsignada = $personaController->buscar($arregloBuscarPersonaAsignada);
        $listaPersonaAsignada = json_decode($listaPersonaAsignada);
        $objPersonaAsignado = $listaPersonaAsignada[0];

        // Obtenemos el usuario de la persona asignada del trabajo (en ella esta su mail)
       
        $idUsuarioAsignado = $objPersonaAsignado->idUsuario;
        $arregloBuscarUsuarioAsignado = ['idUsuario'=>$idUsuarioAsignado];
        $arregloBuscarUsuarioAsignado = new Request($arregloBuscarUsuarioAsignado);
        $listaUsuarioAsignado = $usuarioController->buscar($arregloBuscarUsuarioAsignado);
        $listaUsuarioAsignado = json_decode($listaUsuarioAsignado);
        $objUsuarioAsignado = $listaUsuarioAsignado[0];

        $listaMultas=$multaController->buscar($arregloBuscarTrabajo);
        $listaMultas = json_decode($listaMultas);
        $objMulta = $listaMultas[0];

        
        $mail = new EmailController;
        if ($mail->enviarMailAsignadoCancelado($objUsuarioAsignado,$objPersonaAsignado,$objMulta,$objTrabajo,$objPersonaCreador)){
            $respuesta = true;
        } else {
            $respuesta = false;
        }
        
        return $respuesta;
    }

    // Recibimos por parametro el id trabajo. Enviamos a la funcion del email controller el obj trabajo, obj persona creador de este, objpersona y objusuario del asignado 
    // Aca llama a la funcion que va a enviar el mail que le envia confirmando al creador que cancelo su anuncio
    public function enviarMailCreadorCancelado (request $request){
        // Hacemos la creacion de los objs controladores
        $trabajoAsignadoController = new TrabajoasignadoController;
        $personaController = new PersonaController;
        $usuarioController = new UserController;
        $trabajoController = new TrabajoController;
        $multaController = new MultaController();
        $idTrabajo = $request->idTrabajo; // Obtenemos el id del trabajo para buscar el trabajo 

        // Obtenemos el trabajo que se asigno
        $arregloBuscarTrabajo = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajo = new Request($arregloBuscarTrabajo);
        $listaTrabajo = $trabajoController->buscar($arregloBuscarTrabajo);
        $listaTrabajo = json_decode($listaTrabajo);
        $objTrabajo = $listaTrabajo[0];

        // Obtenemos el idPersona del creador del trabajo

        $idPersonaCreador = $objTrabajo->idPersona;
        $arregloBuscarPersonaCreador = ['idPersona'=>$idPersonaCreador];
        $arregloBuscarPersonaCreador = new Request($arregloBuscarPersonaCreador);
        $listaPersonaCreador = $personaController->buscar($arregloBuscarPersonaCreador);
        $listaPersonaCreador = json_decode($listaPersonaCreador);
        $objPersonaCreador = $listaPersonaCreador[0];

        // Buscamos el trabajo asignado
        $arregloBuscarTrabajoAsignado = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarTrabajoAsignado = new Request($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = $trabajoAsignadoController->buscar($arregloBuscarTrabajoAsignado);
        $listaTrabajoAsignado = json_decode($listaTrabajoAsignado);
        $objTrabajoAsignado = $listaTrabajoAsignado[0]; // Obtenemos el trabajo asignado
        
        // Obtenemos el idPersona de la persona asignada del trabajo

        $idPersonaAsignado = $objTrabajoAsignado->idPersona;
        $arregloBuscarPersonaAsignada = ['idPersona'=>$idPersonaAsignado];
        $arregloBuscarPersonaAsignada = new Request($arregloBuscarPersonaAsignada);
        $listaPersonaAsignada = $personaController->buscar($arregloBuscarPersonaAsignada);
        $listaPersonaAsignada = json_decode($listaPersonaAsignada);
        $objPersonaAsignado = $listaPersonaAsignada[0];

        // Obtenemos el usuario de la persona asignada del trabajo (en ella esta su mail)
    
        $idUsuarioCreador = $objPersonaCreador->idUsuario;
        $arregloBuscarUsuarioCreador = ['idUsuario'=>$idUsuarioCreador];
        $arregloBuscarUsuarioCreador = new Request($arregloBuscarUsuarioCreador);
        $listaUsuarioCreador = $usuarioController->buscar($arregloBuscarUsuarioCreador);
        $listaUsuarioCreador = json_decode($listaUsuarioCreador);
        $objUsuarioCreador = $listaUsuarioCreador[0];

        
        $arregloBuscarMulta = ['idTrabajo'=>$idTrabajo];
        $arregloBuscarMulta = new Request($arregloBuscarMulta);
        $listaMultas = $multaController->buscar($arregloBuscarMulta);
        $listaMultas = json_decode($listaMultas);
        $objMulta = $listaMultas[0];

        $mail = new EmailController;
        if ($mail->enviarMailCreadorCancelado($objUsuarioCreador,$objPersonaAsignado,$objMulta,$objTrabajo,$objPersonaCreador)){
            $respuesta = true;
        } else {
            $respuesta = false;
        }
        return $respuesta;
    }
    // Permite buscar todas las multas 
    public function buscar(request $param){
        $query = Multa::OrderBy('idMulta','ASC'); // Ordenamos las valoraciones por este medio

            if (isset($param->idMulta)){
                $query->where("multa.idMulta",$param->idMulta);
            }

            if (isset($param->valor)){
                $query->where("multa.valor",$param->valor);
            }

            if (isset($param->motivo)){
                $query->where("multa.motivo",$param->motivo);
            }

            if (isset($param->idTrabajo)){
                $query->where("multa.idTrabajo",$param->idTrabajo);
            }

            if (isset($param->idPersona)){
                $query->where("multa.idPersona",$param->idPersona);
            }

            if (isset($param->eliminado)){
                $query->where("multa.eliminado",$param->eliminado);
            }

            $listaMultas=$query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaMultas);

    }




}
