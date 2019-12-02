<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Persona;
use App\Trabajo;
Use App\ConversacionChat;
use App\Http\Controllers\MensajeChatController;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class ConversacionChatController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $conversaciones=ConversacionChat::orderBy('idConversacionChat','DESC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('conversacionchat.index',compact('conversaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $arregloBuscarTrabajos=['eliminado'=>0];
        $arregloBuscarTrabajos = new Request($arregloBuscarTrabajos);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaTrabajos=json_decode($listaTrabajos);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas=json_decode($listaPersonas);
        return view('conversacionchat.create',['listaTrabajos'=>$listaTrabajos,'listaPersonas'=>$listaPersonas]); //Vista para crear el elemento nuevo
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 'idTrabajo'=>'required','idPersona1'=>'required','idPersona2'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        ConversacionChat::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('conversacionchat.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $conversaciones=ConversacionChat::find($id); //Buscamos el elemento para mostrarlo
        return  view('conversacionchat.show',compact('conversaciones'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $conversacion=ConversacionChat::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        $arregloBuscarTrabajos=['eliminado'=>0];
        $arregloBuscarTrabajos = new Request($arregloBuscarTrabajos);
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarPersonas = new Request($arregloBuscarPersonas);
        $trabajoController = new TrabajoController();
        $personaController = new PersonaController();
        $listaTrabajos=$trabajoController->buscar($arregloBuscarTrabajos);
        $listaTrabajos=json_decode($listaTrabajos);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas=json_decode($listaPersonas);

        return view('conversacionchat.edit',compact('conversacion'),['listaPersonas'=>$listaPersonas,'listaTrabajos'=>$listaTrabajos]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[ 'idTrabajo'=>'required','idPersona1'=>'required','idPersona2'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        ConversacionChat::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('conversacionchat.index')->with('success','Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // Actualizamos eliminado a 1 (Borrado lógico)
        ConversacionChat::where('idConversacionChat',$id)->update(['eliminado'=>1]);
        //ConversacionChat::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('conversacionchat.index')->with('success','Registro eliminado satisfactoriamente');
    }

    // Esta funcion busca todas las conversaciones con parametros que le enviemos
    public function buscar(Request $param){      
        $query = ConversacionChat::orderBy('idConversacionChat','DESC'); // Ordenamos las conversaciones por este medio
           
            if (isset($param->idConversacionChat)){
                $query->where("conversacionchat.idConversacionChat",$param->idConversacionChat);
            }

            if (isset($param->idTrabajo)){
                $query->where("conversacionchat.idTrabajo",$param->idTrabajo);
            }

            if (isset($param->idPersona1)){
                $query->where("conversacionchat.idPersona1",$param->idPersona1);
            }

            if (isset($param->idPersona2)){
                $query->where("conversacionchat.idPersona2",$param->idPersona2);
            }

            if (isset($param->eliminado)){
                $query->where("conversacionchat.eliminado",$param->eliminado);
            }
            
            if (isset($param->idPersona)){
                $query->where("conversacionchat.idPersona1",$param->idPersona);
                $query->orwhere("conversacionchat.idPersona2",$param->idPersona);
            }

            $listaConversacionChat=$query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaConversacionChat);
    }
    /**
     * Lista las conversaciones de un usuario con sus respectivos obj persona
     */
    public function listarConversacionesFlutter(Request $request){
        $personaController= new PersonaController;
        //busco las conversaciones de una persona
        $listaConversacionChat= $this->buscar($request);
        $listaConversacionChat=json_decode($listaConversacionChat);
        //por cada conversacion busco las personas involucradas
        foreach ($listaConversacionChat as $conversacion){
            $persona1=$conversacion->idPersona1;
            $request= new Request(['idPersona'=>$persona1]);
            $persona1=json_decode($personaController->buscar($request));
            $persona2=$conversacion->idPersona2;
            $request= new Request(['idPersona'=>$persona2]);
            $persona2=json_decode($personaController->buscar($request));
            //setea un nuevo param llamado persona1 o persona2 donde se guarda el objeto persona por cada conversacion
            $conversacion->persona1= $persona1;
            $conversacion->persona2= $persona2;
            $listaConversaciones []= $conversacion;
        }
        return $listaConversaciones;
    }

    public function misconversaciones(request $param){

        $personaController = new PersonaController();
        //Para ello primero vemos quien esta logeado y tomamos su idUsuario
        $idUsuario = Auth::user()->idUsuario;
        $param = ['idUsuario' => $idUsuario, 'eliminado' => 0];
        $param = new Request($param);
        $persona = $personaController->buscar($param);
        $persona = json_decode($persona);
        $idPersona = $persona[0]->idPersona;
        $paramIdPersona = ['idPersona'=>$idPersona];
        $paramIdPersona = new Request($paramIdPersona);
        $conversacionChatController = new ConversacionChatController();
        $mensajeChatController = new MensajeChatController();
        $listaConversaciones = $conversacionChatController->buscar($paramIdPersona);
        $listaConversaciones = json_decode($listaConversaciones);
        $listaConversaciones=ConversacionChat::orderBy('idConversacionChat','DESC')->where('eliminado','0')->where('idPersona1',$idPersona)->orWhere('idPersona2',$idPersona)->get(); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        // A cada conversacion le agregamos el ulltimo mensaje que tengamos en ese momento
        // Despues lo actualiza vue
     
        foreach ($listaConversaciones as $conversacion){
            $idConversacionChat = $conversacion->idConversacionChat;
            $arregloBuscarMensajes = ['idConversacionChat'=>$idConversacionChat];
            
            $arregloBuscarMensajes = new Request($arregloBuscarMensajes);
            $listaMensajes = $mensajeChatController->buscar($arregloBuscarMensajes);
            $listaMensajes = json_decode($listaMensajes);
            $cantidadMensajes = count($listaMensajes);
            if ($cantidadMensajes>0){
                $ultimoMensaje = $listaMensajes[$cantidadMensajes-1]; // Obtenemos el ultimo mensaje
                $conversacion['ultimoMensaje'] = $ultimoMensaje; // Se lo asignamos
            }
        }
      //  $listaConversaciones=ConversacionChat::orderBy('idConversacionChat','DESC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('conversacionchat.misconversaciones',compact('listaConversaciones'));

    }

    public function miChat(Request $request){        
        $personaController = new PersonaController();
        //Buscamos la persona logeada
        $idUsuario = Auth::user()->idUsuario;
        $param = ['idUsuario' => $idUsuario, 'eliminado' => 0];
        $param = new Request($param);
        $persona = $personaController->buscar($param);
        $persona = json_decode($persona);
        $idPersona = $persona[0]->idPersona;
        //Buscamos la conversacion del anuncio
        $paramConversacionAnuncio = ['idTrabajo'=>$request->idTrabajo];
        $paramConversacionAnuncio = new Request($paramConversacionAnuncio);
        $conversacionChatController = new ConversacionChatController();
        $mensajeChatController = new MensajeChatController();
        $conversacion = $conversacionChatController->buscar($paramConversacionAnuncio);
        $conversacion = json_decode($conversacion);
        //Enviamos todos los elementos y los ordenamos en forma desedente
        //Paginacion de 15 elementos por pagina
        $conversacion=ConversacionChat::orderBy('idConversacionChat','DESC')->where('eliminado','0')->where('idPersona1',$idPersona)->orWhere('idPersona2',$idPersona)->get(); 
        
        $idConversacionChat = $conversacion->idConversacionChat;
        $arregloBuscarMensajes = ['idConversacionChat'=>$idConversacionChat];
        
        $arregloBuscarMensajes = new Request($arregloBuscarMensajes);
        $listaMensajes = $mensajeChatController->buscar($arregloBuscarMensajes);
        $listaMensajes = json_decode($listaMensajes);
        $cantidadMensajes = count($listaMensajes);
        if ($cantidadMensajes>0){
            $ultimoMensaje = $listaMensajes[$cantidadMensajes-1]; // Obtenemos el ultimo mensaje
            $conversacion['ultimoMensaje'] = $ultimoMensaje; // Se lo asignamos
        }
        

        return view('conversacionchat.chat', compact('conversacion'));
    }

}
