<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use Auth;
use App\Persona;
Use App\ConversacionChat;
Use App\MensajeChat;
use App\Http\Controllers\PersonaController;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class MensajeChatController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $mensajeschats=MensajeChat::orderBy('idMensajeChat','ASC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('mensajechat.index',compact('mensajeschats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $arregloBuscarConversaciones=['eliminado'=>0];
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarConversaciones = new Request($arregloBuscarConversaciones);
        $arregloBuscarPersonas=new Request($arregloBuscarPersonas);
        $conversacionChatController = new ConversacionChatController();
        $personaController = new PersonaController();
        $listaConversaciones=$conversacionChatController->buscar($arregloBuscarConversaciones);
        $listaConversaciones = json_decode($listaConversaciones);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);
        return view('mensajechat.create',['listaPersonas'=>$listaPersonas,'listaConversaciones'=>$listaConversaciones]); //Vista para crear el elemento nuevo
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
        $this->validate($request,['idConversacionChat'=>'required','mensaje'=>'required','idPersona'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        MensajeChat::create($request->all()); //Creamos el elemento nuevo
        return redirect()->route('mensajechat.index')->with('success','Registro creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $mensajee=MensajeChat::find($id); //Buscamos el elemento para mostrarlo
        return  view('mensajechat.show',compact('mensaje'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $arregloBuscarConversaciones=['eliminado'=>0];
        $arregloBuscarPersonas=['eliminado'=>0];
        $arregloBuscarConversaciones = new Request($arregloBuscarConversaciones);
        $arregloBuscarPersonas=new Request($arregloBuscarPersonas);
        $conversacionChatController = new ConversacionChatController();
        $personaController = new PersonaController();
        $listaConversaciones=$conversacionChatController->buscar($arregloBuscarConversaciones);
        $listaConversaciones = json_decode($listaConversaciones);
        $listaPersonas=$personaController->buscar($arregloBuscarPersonas);
        $listaPersonas = json_decode($listaPersonas);
        $mensaje=MensajeChat::find($id); //Buscamos el elemento para cargarlo en la vista para luego editarlo
        return view('mensajechat.edit',compact('mensaje'),['listaPersonas'=>$listaPersonas,'listaConversaciones'=>$listaConversaciones]);
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
        $this->validate($request,['idConversacionChat'=>'required','mensaje'=>'required','idPersona'=>'required']); //Validamos los datos antes de guardar el elemento nuevo
        MensajeChat::find($id)->update($request->all()); //Actualizamos el elemento con los datos nuevos
        return redirect()->route('mensajechat.index')->with('success','Registro actualizado satisfactoriamente');
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
        MensajeChat::where('idMensajeChat',$id)->update(['eliminado'=>1]);
        //MensajeChat::find($id)->delete(); //Buscamos y eliminamos el elemento
        return redirect()->route('mensajechat.index')->with('success','Registro eliminado satisfactoriamente');
    }
    public function buscarMensajes(){
        $objMensaje= new MensajeChat();
        $listaMensajes = $objMensaje->get();
        return json_encode($listaMensajes);
    }
    
    // Permite buscar todas los mensajes
    public function buscar(Request $param){      
        $query = MensajeChat::OrderBy('idMensajeChat','ASC'); // Ordenamos los mensajes este medio
            
            if (isset($param->idMensajeChat)){
                $query->where("mensajechat.idMensajeChat",$param->idMensajeChat);
            }

            if (isset($param->idConversacionChat)){
                $query->where("mensajechat.idConversacionChat",$param->idConversacionChat);
            } 
            if (isset($param->idPersona)){
                $query->where("mensajechat.idPersona",$param->idPersona);
            }

            if (isset($param->mensaje)){
                $query->where("mensajechat.mensaje",$param->mensaje);
            }

            if (isset($param->eliminado)){
                $query->where("mensajechat.eliminado",$param->eliminado);
            }
            $listaMensajeChat=$query->get();   // Hacemos el get y seteamos en lista
            return json_encode($listaMensajeChat);
    }

    //lista los mensajes de una conversacion y por cada uno busca la persona y el usuario
    public function listarMensajesConversacion(Request $param){
        $listaMensajesConversacion= $this->buscar($param);
        $listaMensajesConversacion= json_decode($listaMensajesConversacion);
        $listaMensajes= array();
        $personaController=new PersonaController;
        $usuarioController=new UserController;
        foreach($listaMensajesConversacion as $mensajeConversacion){
            $idPersona=$mensajeConversacion->idPersona;
            $idPersona= ['idPersona'=>$idPersona];
            $idPersona= new Request($idPersona);
            //busca la persona que envio el mensaje
            $objPersona= $personaController->buscar($idPersona);
            $objPersona=json_decode($objPersona);
            $idUsuario= $objPersona[0]->idUsuario;
            $idUsuario= ['idUsuario'=>$idUsuario];
            $idUsuario= new Request($idUsuario);
            //busca el usuario de la persona
            $objUsuario= $usuarioController->buscar($idUsuario);
            $objUsuario= json_decode($objUsuario);
            //setea un nuevo param llamado usuario donde se guarda el objeto usuario por cada mensaje
            $mensajeConversacion->usuario= $objUsuario;
            array_push($listaMensajes,$mensajeConversacion);
        }
        //print_r($listaMensajes);
        return $listaMensajes;
    }
    public function fetch($idConversacionChat)
    {
        return MensajeChat::with('persona')->where('idConversacionChat',$idConversacionChat)->get();
        
    }

    public function sentMessage(Request $request)
    {
        $idUsuario = Auth::user()->idUsuario;
        //Con el idUsuario buscamos la persona
        $persona = Persona::where('idUsuario',$idUsuario)->first(); // Lo buscamos asi porque tiene que ser un app/persona
        $idConversacionChat = $request->idConversacionChat; // ya recibimos el id conversacion
        
        $mensaje = MensajeChat::create([
            'mensaje' => $request->mensaje['mensaje'], // ya recibimos el msj
            'idConversacionChat'=>$request->idConversacionChat,
            'idPersona'=>$request->mensaje['persona']['idPersona'], // ya recibimos la persona
            
        ]);
        
        broadcast(new MessageSent($persona, $mensaje, $idConversacionChat))->toOthers();
    }

    public function indexDos()
    {
        //$mensajeschats=MensajeChat::orderBy('idMensajeChat','ASC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('chat/chat');
    }

    public function mensajesconversacion($idConversacionChat){
        $personaController = new PersonaController();
        //Para ello primero vemos quien esta logeado y tomamos su idUsuario
        $idUsuario = Auth::user()->idUsuario;
        $param = ['idUsuario' => $idUsuario, 'eliminado' => 0];
        $param = new Request($param);
        $persona = $personaController->buscar($param);
        $persona = json_decode($persona);
        $idPersona = $persona[0]->idPersona;

        $listaMensajes=MensajeChat::orderBy('idMensajeChat','DESC')->where('eliminado','0')->orWhere('idConversacionChat',$idConversacionChat)->get(); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        $listaConversaciones=ConversacionChat::orderBy('idConversacionChat','DESC')->where('eliminado','0')->orWhere('idPersona1',$idPersona)->orWhere('idPersona2',$idPersona)->get(); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
      //  $listaConversaciones=ConversacionChat::orderBy('idConversacionChat','DESC')->where('eliminado','0')->paginate(15); //Mandamos todos los elementos y los ordenamos en forma desedente, paginamos con 15 elementos por pagina
        return view('conversacionchat.misconversaciones',compact('listaMensajes'),['listaConversaciones'=>$listaConversaciones]);
    }

    public function actualizarvisto(request $request){
        $idConversacionChat = $request->idConversacionChat;


        if (isset($request->idPersonaLogeada)){ // Significa que esta en laravel y ya tenemos el id persona logeada
            // Hay que poner el visto en los mensajes de la otra persona
        } else { // Significa que esta en laravel y hay que buscar el id persona
            $controlPersona = new PersonaController;
            $idUsuario = Auth::user()->idUsuario;
            $param = ['idUsuario' => $idUsuario, 'eliminado' => 0];
            $param = new Request($param);
            $persona = $controlPersona->buscar($param);
            $persona = json_decode($persona);
            $idPersonaLogeada = $persona[0]->idPersona;
        }

            MensajeChat::where('idPersona','!=',$idPersonaLogeada)->update(['visto'=>1,'fechaVisto'=>now()]);



    }


}
